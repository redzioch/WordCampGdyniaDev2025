<?php
require __DIR__ . '/vendor/autoload.php';

use LLPhant\Embeddings\EmbeddingGenerator\OpenAI\OpenAI3SmallEmbeddingGenerator;

$embeddingGenerator = new OpenAI3SmallEmbeddingGenerator();