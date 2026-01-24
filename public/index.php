<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Autoload Composer dependencies
require __DIR__.'/../vendor/autoload.php';

// Bootstrap the application
$app = require_once __DIR__.'/../bootstrap/app.php';

/** @var Kernel $kernel */
$kernel = $app->make(Kernel::class);

// Capture the request and send the response
$response = $kernel->handle(
    $request = Request::capture()
);

$response->send();

// Terminate the kernel (for middleware, etc.)
$kernel->terminate($request, $response);
