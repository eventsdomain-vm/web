<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$request = Illuminate\Http\Request::create('/sponsor/plan/objectives', 'GET');
$request->headers->set('Host', 'vm.site');

// Find a sponsor user to authenticate as
$user = \App\Models\User::whereHas('roles', function($q) { $q->where('name', 'sponsor'); })->first();

if ($user) {
    echo "User: {$user->name} (ID: {$user->id})" . PHP_EOL;
    echo "Roles: " . $user->roles->pluck('name')->implode(', ') . PHP_EOL;
    echo "Has sponsor role: " . ($user->hasRole('sponsor') ? 'yes' : 'no') . PHP_EOL;
    
    $request->setUserResolver(function() use ($user) { return $user; });
    
    $kernel = app()->make(Illuminate\Contracts\Http\Kernel::class);
    $response = $kernel->handle($request);
    
    echo 'Status: ' . $response->getStatusCode() . PHP_EOL;
    echo 'Content: ' . substr($response->getContent(), 0, 500) . PHP_EOL;
} else {
    echo "No sponsor user found!" . PHP_EOL;
}