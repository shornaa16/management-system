<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\QueryException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // রেন্ডারের প্রক্সি ট্রাস্ট করার জন্য এটি যোগ করুন
        $middleware->trustProxies(at: '*');

        // Redirect unauthenticated users to /login (instead of Laravel's default)
        $middleware->redirectGuestsTo('/login');
        // Authenticated users land on the dashboard
        $middleware->redirectUsersTo('/dashboard');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );

        // Friendly 404 page (no debug details exposed)
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if (! $request->expectsJson()) {
                return response()->view('errors.404', [], 404);
            }
        });

        $exceptions->render(function (HttpException $e, Request $request) {
            if (! $request->expectsJson() && in_array($e->getStatusCode(), [403, 500, 503], true)) {
                $view = 'errors.' . $e->getStatusCode();
                if (view()->exists($view)) {
                    return response()->view($view, [], $e->getStatusCode());
                }
            }
        });

        // Never expose raw DB exceptions to the user - show a friendly message instead.
        $exceptions->render(function (QueryException $e, Request $request) {
            if (! $request->expectsJson() && app()->environment('production')) {
                return response()->view('errors.db', [], 500);
            }
        });
    })->create();