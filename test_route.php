<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$request = Illuminate\Http\Request::create('/sponsor/plan/objectives', 'GET');
$request->headers->set('Host', 'vm.site');

$response = $kernel->handle($request);

echo 'Status: ' . $response->getStatusCode() . PHP_EOL;
echo 'Content: ' . substr($response->getContent(), 0, 500) . PHP_EOL;