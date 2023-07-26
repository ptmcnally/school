<?php

namespace App\Providers;

use App\Services\WondeService;
use Illuminate\Support\ServiceProvider;

class WondeServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(WondeService::class, function () {
            return new WondeService(
                new \Wonde\Client(config('wonde.school.api_key'))
            );
        });
    }
}
