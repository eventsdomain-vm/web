<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Test with find(1)
$sponsor = \App\Models\Sponsor::with(['contracts'])->find(1);
echo "Sponsor (find 1): " . ($sponsor ? $sponsor->name : 'not found') . PHP_EOL;

if ($sponsor) {
    $contracts = $sponsor->contracts;
    echo "Contracts type: " . gettype($contracts) . PHP_EOL;
    echo "Contracts class: " . get_class($contracts) . PHP_EOL;
    
    if ($contracts instanceof \Illuminate\Database\Eloquent\Collection) {
        echo "Count: " . $contracts->count() . PHP_EOL;
    }
    
    $whereResult = $contracts->where('signed_at');
    echo "Where result type: " . gettype($whereResult) . " class: " . get_class($whereResult) . PHP_EOL;
    
    if ($whereResult instanceof \Illuminate\Database\Eloquent\Collection) {
        $isNotEmpty = $whereResult->isNotEmpty();
        echo "isNotEmpty: " . ($isNotEmpty ? 'true' : 'false') . PHP_EOL;
        if ($isNotEmpty) {
            echo "Where count after isNotEmpty: " . $whereResult->count() . PHP_EOL;
        } else {
            echo "Where count (isNotEmpty false): " . $whereResult->count() . PHP_EOL;
        }
    }
    
    // Test the exact line from the service
    try {
        $signedCount = $sponsor->contracts->where('signed_at')->isNotEmpty()->count();
        echo "signed count: " . $signedCount . PHP_EOL;
    } catch (Exception $e) {
        echo "ERROR: " . $e->getMessage() . PHP_EOL;
        echo "File: " . $e->getFile() . " Line: " . $e->getLine() . PHP_EOL;
    }
}