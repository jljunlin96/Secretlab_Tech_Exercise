<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->group('api', [
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            'throttle:60,1',
            App\Http\Middleware\ApiRouting::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();


// Return the app instance
return $app;
