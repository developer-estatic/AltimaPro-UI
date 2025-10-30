<?php

use App\Http\Middleware\LogValidationErrors;
use App\Http\Middleware\RequestIdentifier;
use App\Http\Middleware\SetLocale;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Bootstrap\HandleExceptions;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Exceptions\CustomUnauthorizedException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Exceptions\UnauthorizedException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'encrypt' => \App\Http\Middleware\PrimaryKeyEncrypt::class,
            'check_permission' => \App\Http\Middleware\CheckPermission::class,
        ]);
        $middleware->web(append: [
            SetLocale::class,
            RequestIdentifier::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable $e, Request $request) {
            if ($e instanceof UnauthorizedException) {
                log_incident($e);
                return response()->view('errors.403', [
                    "exception" => $e,
                    "incident_id" => $request->get("incident_id"),
                ]);
            }
        });
    })->create();

