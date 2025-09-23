<?php
require __DIR__ . '/vendor/autoload.php';

use Predis\Client as PredisClient;
use LLPhant\Embeddings\VectorStores\Redis\RedisVectorStore;

use LLPhant\Embeddings\Document;
use LLPhant\Embeddings\DocumentSplitter\DocumentSplitter;

use LLPhant\Embeddings\EmbeddingGenerator\OpenAI\OpenAI3SmallEmbeddingGenerator;

use LLPhant\Chat\OpenAIChat;
use LLPhant\OpenAIConfig;
use LLPhant\Chat\Message;
use LLPhant\Chat\Enums\ChatRole;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$chunkSize = 800; // Tune for your data; try 500–1200
$overlap   = 100; // Tune for your data; try 50–200

// 3) Generate long string to sample splitted text
$config = new OpenAIConfig();
$chat = new OpenAIChat($config);
$response = $chat->generateText('Generate a random readable text of approximately 1200 bytes. Do not explain, just return the raw string.');

// Sample data: array of ['id' => string, 'text' => string]
$records = [
  ['id' => 'faq-001', 'text' => "Your first long string…"],
  ['id' => 'faq-002', 'text' => "Another string to vectorize..."],
  ['id' => 'faq-003', 'text' => $response],
  // …add as many as you want
];

// 1) Wrap your strings as LLPhant Documents
$docs = [];
foreach ($records as $r) {
    $d = new Document();
    $d->content  = $r['text'];
    $d->metadata = ['doc_id' => $r['id'], 'source' => 'inline'];
    $docs[] = $d;
}

// 2) Split into chunks while preserving metadata
$chunks = [];
foreach ($docs as $doc) {
    $splitDocs = DocumentSplitter::splitDocument($doc, $chunkSize, ' ', $overlap); // you can also split by sentece ('. ')
    foreach ($splitDocs as $i => $chunk) {
        // copy original metadata + add chunk index
        $chunk->metadata = (isset($doc->metadata) ? $doc->metadata : []) + ['chunk_idx' => $i];
        $chunks[] = $chunk;
    }
}

print_r($chunks);