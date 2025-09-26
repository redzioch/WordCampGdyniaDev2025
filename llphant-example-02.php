<?php

/*
 * Embedings example
 */

require __DIR__ . '/vendor/autoload.php';

use LLPhant\Embeddings\EmbeddingGenerator\OpenAI\OpenAI3SmallEmbeddingGenerator;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Simple cosine similarity function
function cosineSimilarity(array $vec1, array $vec2): float {
  $dotProduct = 0.0;
  $normA = 0.0;
  $normB = 0.0;
  foreach ($vec1 as $i => $val) {
    $dotProduct += $val * $vec2[$i];
    $normA += $val * $val;
    $normB += $vec2[$i] * $vec2[$i];
  }
  return $dotProduct / (sqrt($normA) * sqrt($normB));
}

$embeddingGenerator = new OpenAI3SmallEmbeddingGenerator();
$embedding1 = $embeddingGenerator->embedText('How to install WordPress?');
$embedding2 = $embeddingGenerator->embedText('How to install cabinet?');

// display sample the generated embeddings
printf("Embedding 1 count: %d\n", count($embedding1));
printf("Embedding 1 sample: %s...\n", implode(', ', array_slice($embedding1, 0, 10)));
printf("Embedding 2 count: %d\n", count($embedding2));
printf("Embedding 2 sample: %s...\n", implode(', ', array_slice($embedding2, 0, 10)));

// compute cosine similarity
$diff = array_diff($embedding1, $embedding2);
$similarity = cosineSimilarity($embedding1, $embedding2);
printf("Cosine similarity: %f\n", $similarity);