<?php
require __DIR__ . '/vendor/autoload.php';

use Predis\Client as PredisClient;
use Dhosting\VectorStore\DocumentVectorStore;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$redis = new PredisClient([
    'scheme' => 'unix',
    'path'   => $_ENV['REDIS_SOCKET_PATH'],
]);

$store = new \Dhosting\VectorStore\DocumentVectorStore($redis, $_ENV['REDIS_INDEX_NAME']);

// $store = new DocumentVectorStore($redis, index: 'my_docs');
$store->add('faq-001', "Original content...", ['category' => 'faq']);
// $results = $store->search("authentication", 3);
// print_r($results);