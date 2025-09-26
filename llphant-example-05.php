<?php

/*
 * Reranking search results with LLM example
 */

require __DIR__ . '/vendor/autoload.php';

use Predis\Client as PredisClient;
use Dhosting\VectorStore\DocumentVectorStore;

use LLPhant\Query\SemanticSearch\LLMReranker;
use LLPhant\Chat\OpenAIChat;
use LLPhant\OpenAIConfig;
use LLPhant\Embeddings\Document;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$redis = new PredisClient($_ENV['REDIS_URL']);
$store = new \Dhosting\VectorStore\DocumentVectorStore($redis, $_ENV['REDIS_INDEX_NAME']);

$question = "How to add new post";

$k = 10; // Reduce to 5 to make reranking more reliable
$initial = $store->search($question, $k); // returns array with 'content' and 'metadata'

// 2) convert to LLPhant Document[]
$docs = [];
foreach ($initial as $r) {
    $d = new Document();
    $d->content  = (string)($r['content'] ?? '');
    $docs[] = $d;
}

echo "Initial search results:\n";
foreach ($docs as $i => $doc) {
  echo ($i + 1) . ". " . substr($doc->content, 0, 200) . "...\n";
}
echo "\n";

// 3) run LLM-based reranker to keep the N most relevant
$n = 10; // how many you want to keep after rerank
$reranker = new LLMReranker(new OpenAIChat(new OpenAIConfig()), $n);

// Try reranking with fallback to simple truncation if it fails
try {
    echo "Attempting LLM-based reranking...\n";
    $rerankedDocs = $reranker->transformDocuments([$question], $docs);
    echo "LLM reranking successful.\n";
} catch (Exception $e) {
    echo "LLM reranking failed: " . $e->getMessage() . "\n";
    echo "Falling back to simple truncation of top results.\n";
    // Fallback: just take the first N documents (they're already ranked by vector similarity)
    $rerankedDocs = array_slice($docs, 0, $n);
}
echo "\n";

// $rerankedDocs is an array<Document> in best→worst order, length ≤ $n
echo "Top " . count($rerankedDocs) . " most relevant results:\n";

foreach ($rerankedDocs as $i => $d) {
    echo ($i + 1) . ". " . substr($d->content, 0, 200) . "...\n";
}
