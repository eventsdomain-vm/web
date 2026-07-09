<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    $sponsor = \App\Models\Sponsor::find(1);
    echo "Sponsor: " . ($sponsor ? $sponsor->name : 'not found') . PHP_EOL;
    
    if ($sponsor) {
        echo "Contracts relationship exists: " . (method_exists($sponsor, 'contracts') ? 'yes' : 'no') . PHP_EOL;
        
        $contracts = $sponsor->contracts;
        echo "Contracts type: " . gettype($contracts) . PHP_EOL;
        echo "Contracts class: " . get_class($contracts) . PHP_EOL;
        
        if (method_exists($contracts, 'count')) {
            echo "Count: " . $contracts->count() . PHP_EOL;
        }
        
        // Test the contracts relationship
        $contractsRelation = $sponsor->contracts();
        echo "Contracts relation class: " . get_class($contractsRelation) . PHP_EOL;
        
        // Try to get contracts
        $results = $contractsRelation->get();
        echo "Results count: " . $results->count() . PHP_EOL;
        echo "Results type: " . get_class($results) . PHP_EOL;
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
    echo "File: " . $e->getFile() . " Line: " . $e->getLine() . PHP_EOL;
    echo "Trace: " . $e->getTraceAsString() . PHP_EOL;
}