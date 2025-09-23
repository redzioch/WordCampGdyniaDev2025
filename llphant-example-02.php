<?php
require __DIR__ . '/vendor/autoload.php';

use LLPhant\Embeddings\EmbeddingGenerator\OpenAI\OpenAI3SmallEmbeddingGenerator;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$embeddingGenerator = new OpenAI3SmallEmbeddingGenerator();
$embedding = $embeddingGenerator->embedText('I love food');

print_r($embedding);