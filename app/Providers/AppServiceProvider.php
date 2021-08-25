<?php

namespace App\Providers;

use ConsoleTVs\Charts\Registrar as Charts;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Charts $charts)
    {
        // Prevent N+1 Queries by Disabling Them in Local development
        // https://www.youtube.com/watch?v=bLWYbyKcfYI
        Model::preventLazyLoading(! app()->isProduction());

        // Binding for units
        $this->app->bind('units', function () {
            return array(
                'standard' => [
                    'temp' => 'K',
                    'wind' => 'm/s'
                ],
                'metric' => [
                    'temp' => '°C',
                    'wind' => 'm/s'
                ],
                'imperial' => [
                    'temp' => '°F',
                    'wind' => 'mph'
                ],
            );
        });

    }
}
