<?php

namespace App\Providers;

use App\Interfaces\IDataPointInterface;
use App\Interfaces\IStatisticsCalculator;
use App\Services\DataPoint;
use App\Services\StatisticsCalculator;
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
        // Binding interface and concrete class
        $this->app->bind(
            IStatisticsCalculator::class,
            StatisticsCalculator::class
        );

        $this->app->bind(
            IDataPointInterface::class,
            DataPoint::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
