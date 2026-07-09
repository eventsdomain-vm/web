<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$user = \App\Models\User::whereHas('roles', function($q) { $q->where('name', 'sponsor'); })->first();

$urls = [
    '/sponsor/plan',
    '/sponsor/plan/budgets',
];

foreach ($urls as $url) {
    $request = \Illuminate\Http\Request::create($url, 'GET');
    $request->headers->set('Host', 'vm.site');
    $request->setUserResolver(function() use ($user) { return $user; });
    
    $session = $app->make('session.store');
    $session->put('login_web_' . sha1('web'), $user->getAuthIdentifier());
    $request->setLaravelSession($session);
    \Illuminate\Support\Facades\Auth::guard('web')->setUser($user);

    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    $response = $kernel->handle($request);
    
    echo "$url -> Status: {$response->getStatusCode()}" . PHP_EOL;
    if ($response->getStatusCode() !== 200) {
        echo "Error: " . substr($response->getContent(), 0, 500) . PHP_EOL;
    }
}