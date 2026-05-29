<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))

    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    //setelah logout gabisa masuk halaman setelan login, jadi gabisa baca cache nya we
    ->withMiddleware(function (Middleware $middleware): void {

        $middleware->alias([

            'prevent-back-history' => \App\Http\Middleware\PreventBackHistory::class, //m1
            'check.lockout'        => \App\Http\Middleware\CheckLoginLockout::class,  //m2
        ]);

    })

    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })

    ->create();