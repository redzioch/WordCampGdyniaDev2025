<?php
require __DIR__ . '/vendor/autoload.php';

use Predis\Client as PredisClient;
use Dhosting\VectorStore\DocumentVectorStore;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$redis = new PredisClient($_ENV['REDIS_URL']);
$store = new \Dhosting\VectorStore\DocumentVectorStore($redis, $_ENV['REDIS_INDEX_NAME']);

$results = $store->search("How to install", 5);
print_r($results);
