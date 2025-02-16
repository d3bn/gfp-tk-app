<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__));

// Make sure to use local environment
if (file_exists(__DIR__ . '/../.env.local')) {
    app()->loadEnvironmentFrom('.env.local');
}

return $app->withRouting(
    web: __DIR__.'/../routes/web.php',
    commands: __DIR__.'/../routes/console.php',
    health: '/up',
)
->withMiddleware(function (Middleware $middleware) {
    //
})
->withExceptions(function (Exceptions $exceptions) {
    //
})->create();
