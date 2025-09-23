<?php
require __DIR__ . '/vendor/autoload.php';

use LLPhant\Chat\OpenAIChat;
use LLPhant\OpenAIConfig;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$config = new OpenAIConfig();
$chat = new OpenAIChat($config);

$response = $chat->generateText('What is the capital of Italy?');
// The capital city of Italy is Rome
printf("%s\n", $response);
