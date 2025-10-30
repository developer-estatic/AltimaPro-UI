<?php

namespace App\Providers;

use App\Http\ViewComposers\BusinessUnitComposer;
use App\Http\ViewComposers\CountryComposer;
use App\Http\ViewComposers\RoleComposer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use App\Http\ViewComposers\MenuComposer;
use Illuminate\Support\Facades\View;
use Opcodes\LogViewer\Facades\LogViewer;
use App\Exceptions\Handler;
use Illuminate\Contracts\Debug\ExceptionHandler as ExceptionHandlerContract;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ExceptionHandlerContract::class, Handler::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Carbon::macro('inUserTimezone', function() {
            return $this->tz(auth()->user()->businessUnit?->timezone ?? config('app.timezone'));
        });

        LogViewer::auth(function ($request) {
            if (Auth::check() && hasPermission('log-viewer.index'))
                return true;
            else
                return false;
        });

        // Enable MenuComposer for left-navigation sidebar
        View::composer('layouts.left-navigation', MenuComposer::class);
        // View::composer(['user_management.create', 'user_management.edit'], CountryComposer::class);
        // View::composer(['user_management.create', 'user_management.edit'], BusinessUnitComposer::class);
        // View::composer(['user_management.create', 'user_management.edit'], RoleComposer::class);
    }
}
