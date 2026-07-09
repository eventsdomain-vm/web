<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$sponsor = \App\Models\Sponsor::with(['objectives', 'preferences', 'budgetAllocations', 'campaigns', 'contracts'])->find(1);

echo "Sponsor: " . ($sponsor ? $sponsor->name : 'not found') . PHP_EOL;

if ($sponsor) {
    echo "Contracts (direct): " . gettype($sponsor->contracts) . " - class: " . get_class($sponsor->contracts) . PHP_EOL;
    echo "Campaigns type: " . gettype($sponsor->campaigns) . " - class: " . get_class($sponsor->campaigns) . PHP_EOL;
    echo "Objectives type: " . gettype($sponsor->objectives) . " - class: " . get_class($sponsor->objectives) . PHP_EOL;
    echo "Preferences type: " . gettype($sponsor->preferences) . " - class: " . get_class($sponsor->preferences) . PHP_EOL;
    echo "BudgetAllocations type: " . gettype($sponsor->budgetAllocations) . " - class: " . get_class($sponsor->budgetAllocations) . PHP_EOL;
    
    // Test the contracts collection
    if (method_exists($sponsor->contracts, 'count')) {
        echo "Contracts count: " . $sponsor->contracts->count() . PHP_EOL;
    }
    
    // Test the contracts->where
    $whereResult = $sponsor->contracts->where('signed_at');
    echo "Where result type: " . gettype($whereResult) . " - class: " . get_class($whereResult) . PHP_EOL;
    
    if (method_exists($whereResult, 'isNotEmpty')) {
        $isNotEmpty = $whereResult->isNotEmpty();
        echo "isNotEmpty: " . ($isNotEmpty ? 'true' : 'false') . PHP_EOL;
        
        if (method_exists($whereResult, 'count')) {
            echo "Where count: " . $whereResult->count() . PHP_EOL;
        }
    }
}