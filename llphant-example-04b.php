<?php
require __DIR__ . '/vendor/autoload.php';

use Predis\Client as PredisClient;
use Dhosting\VectorStore\DocumentVectorStore;

echo "Test1";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
echo "Test11";
// $dotenv->load();

echo "Test2";

$redis = new PredisClient($_ENV['REDIS_URL']);

echo "Test3";

$store = new \Dhosting\VectorStore\DocumentVectorStore($redis, $_ENV['REDIS_INDEX_NAME']);

echo "Test4";

// $results = $store->search("How to install", 3);
// print_r($results);
