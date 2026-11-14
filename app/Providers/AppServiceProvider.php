<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        // Native Gate Integration for Dynamic Permissions
        Gate::before(function ($user, $ability) {
            if (isset($user->is_active) && !$user->is_active) {
                return false;
            }
            if (method_exists($user, 'hasRole') && $user->hasRole(['Super Admin', 'super-admin'])) {
                return true;
            }
            return null; // continue to specific ability or Gate::after
        });

        Gate::after(function ($user, $ability) {
            if (method_exists($user, 'hasPermission')) {
                return $user->hasPermission($ability);
            }
            return false;
        });

        // Custom Blade Directives
        Blade::if('role', function ($role) {
            return auth()->check() && method_exists(auth()->user(), 'hasRole') && auth()->user()->hasRole($role);
        });

        Blade::if('permission', function ($permission) {
            return auth()->check() && method_exists(auth()->user(), 'hasPermission') && auth()->user()->hasPermission($permission);
        });
    }
}
