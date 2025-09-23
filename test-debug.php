<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "Step 1: Starting script\n";
flush();

require __DIR__ . '/vendor/autoload.php';
echo "Step 2: Autoloader loaded\n";
flush();

echo "Step 3: Before Dotenv creation\n";
flush();

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
echo "Step 4: After Dotenv creation\n";
flush();

echo "Step 5: Script completed\n";
