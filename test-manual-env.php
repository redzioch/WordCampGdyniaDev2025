<?php
require __DIR__ . '/vendor/autoload.php';

echo "Loading .env manually\n";

// Manual .env loading
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            list($key, $value) = explode('=', $line, 2);
            $_ENV[$key] = $value;
            putenv("$key=$value");
        }
    }
    echo "Environment variables loaded manually\n";
} else {
    echo ".env file not found\n";
}

echo "REDIS_URL: " . ($_ENV['REDIS_URL'] ?? 'not set') . "\n";
echo "REDIS_INDEX_NAME: " . ($_ENV['REDIS_INDEX_NAME'] ?? 'not set') . "\n";
