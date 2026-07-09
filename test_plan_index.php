<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$user = \App\Models\User::whereHas('roles', function($q) { $q->where('name', 'sponsor'); })->first();

$url = '/sponsor/plan';
$request = \Illuminate\Http\Request::create($url, 'GET');
$request->headers->set('Host', 'vm.site');
$request->setUserResolver(function() use ($user) { return $user; });

$session = $app->make('session.store');
$session->put('login_web_' . sha1('web'), $user->getAuthIdentifier());
$request->setLaravelSession($session);
\Illuminate\Support\Facades\Auth::guard('web')->setUser($user);

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle($request);

echo "Status: {$response->getStatusCode()}" . PHP_EOL;
if ($response->getStatusCode() !== 200) {
    echo "Content: " . substr($response->getContent(), 0, 2000) . PHP_EOL;
}