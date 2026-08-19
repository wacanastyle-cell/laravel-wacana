<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::capture();
try {
    $response = $kernel->handle($request);
    echo "HTTP Status: " . $response->getStatusCode() . "\n";
    echo "Content length: " . strlen($response->getContent()) . "\n";
    if ($response->getStatusCode() >= 400) {
        echo "ERROR: " . $response->getContent() . "\n";
    }
} catch (\Exception $e) {
    echo "EXCEPTION: " . $e->getMessage() . "\n";
    echo "FILE: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "TRACE: " . $e->getTraceAsString() . "\n";
}
$kernel->terminate($request, $response);
