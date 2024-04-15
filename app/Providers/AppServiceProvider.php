<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(\App\Http\Interfaces\UserRepositoryInterface::class, \App\Http\Repositories\UserRepository::class);
        $this->app->bind(\App\Http\Interfaces\GponOnusRepositoryInterface::class, \App\Http\Repositories\GponOnusRepository::class);
        $this->app->bind(\App\Http\Interfaces\GponEquipamentsRepositoryInterface::class, \App\Http\Repositories\GponEquipamentsRepository::class);
        $this->app->bind(\App\Http\Interfaces\GponPortsRepositoryInterface::class, \App\Http\Repositories\GponPortsRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}