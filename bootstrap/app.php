<?php

use App\Exceptions\Handler;
use App\Http\Middleware\AuthenticateWithBasicAndToken;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        api: __DIR__.'/../routes/api.php',
        apiPrefix: 'api',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
       
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function(RouteNotFoundException $exceptions, Request $request){
            return response()->json(['message' => 'Unauthorized'], 401);
        });
    })->create();
