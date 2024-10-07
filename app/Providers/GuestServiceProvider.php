<?php

namespace App\Providers;

use App\Interfaces\GuestInterface;
use App\Repositories\GuestRepository;
use Illuminate\Support\ServiceProvider;

class GuestServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(GuestInterface::class, GuestRepository::class);

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
