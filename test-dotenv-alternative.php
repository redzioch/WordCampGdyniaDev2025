<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/vendor/autoload.php';

echo "Testing alternative Dotenv approach\n";

// Try alternative approach
try {
    $dotenv = new Dotenv\Dotenv(__DIR__);
    echo "Alternative 1: new Dotenv() works\n";
} catch (Exception $e) {
    echo "Alternative 1 failed: " . $e->getMessage() . "\n";
}

// Try with explicit .env file
try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__, '.env');
    echo "Alternative 2: createImmutable with explicit file works\n";
} catch (Exception $e) {
    echo "Alternative 2 failed: " . $e->getMessage() . "\n";
}
