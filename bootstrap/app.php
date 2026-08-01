<?php

use App\Helper\V1\ApiResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Auth\AuthenticationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
       

 $exceptions->shouldRenderJsonWhen(
            fn(Request $request) => $request->is('api/*') || $request->expectsJson()
        );

        $exceptions->render(function (AuthenticationException $e) {
            return ApiResponse::unauthorized('Unauthenticated.');
        });

        $exceptions->render(function (ValidationException $e) {
            return ApiResponse::error($e->errors(), 'Validation failed', 422);
        });

        $exceptions->render(function (ModelNotFoundException|NotFoundHttpException $e) {
            return ApiResponse::notFound('Resource not found');
        });

        $exceptions->render(function (AuthorizationException $e) {
            return ApiResponse::forbidden('Not allowed');
        });

        $exceptions->render(function (Throwable $e) {
            report($e);

            return ApiResponse::serverError(
                app()->isProduction() ? 'Internal server error' : $e->getMessage()
            );
        });
    })->create();
