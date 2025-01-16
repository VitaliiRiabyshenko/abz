<?php

use Illuminate\Support\Str;
use Illuminate\Foundation\Application;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withProviders()
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->encryptCookies([
            'laravel_session'
        ]);
        $middleware->append(StartSession::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (NotFoundHttpException $e, $request) {
            if ($e->getPrevious() instanceof ModelNotFoundException) {
                $modelName = class_basename($e->getPrevious()->getModel());
                return response()->json([
                    'success' => false,
                    'message' => Str::headline($modelName) . " not found"
                ], 404);
            }
            return response()->json([
                'success' => false,
                'message' => $e->getMessage() ? $e->getMessage() : 'Page not found'
            ], 404);
        });
        $exceptions->respond(function (Response $response) {
            if ($response->getStatusCode() === 403) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }

            if ($response->getStatusCode() === 500) {
                return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong'
                ], 500);
            }

            return $response;
        });
        $exceptions->renderable(function (AuthenticationException $e, $request) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        });
        $exceptions->renderable(function (ValidationException  $e, $request) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'fails' => $e->errors(),
            ], 422);
        });
    })->create();
