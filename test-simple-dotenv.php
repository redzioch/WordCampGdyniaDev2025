<?php
require __DIR__ . '/vendor/autoload.php';

echo "Testing with a simple directory scan\n";

// Check if Dotenv class exists
if (class_exists('Dotenv\Dotenv')) {
    echo "Dotenv class exists\n";
} else {
    echo "Dotenv class does not exist\n";
    exit(1);
}

// Try using createUnsafeImmutable instead
try {
    $dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
    echo "createUnsafeImmutable works\n";
} catch (Exception $e) {
    echo "createUnsafeImmutable failed: " . $e->getMessage() . "\n";
}

// Try createMutable instead
try {
    $dotenv = Dotenv\Dotenv::createMutable(__DIR__);
    echo "createMutable works\n";
} catch (Exception $e) {
    echo "createMutable failed: " . $e->getMessage() . "\n";
}
