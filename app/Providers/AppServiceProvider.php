<?php

namespace App\Providers;
use Illuminate\Support\Carbon;

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
        Carbon::macro('schoolYear', function () {
        /** @var \Illuminate\Support\Carbon $this */
        $year = $this->year;
        $month = $this->month;

        return $month >= 6
            ? $year . '-' . ($year + 1)
            : ($year - 1) . '-' . $year;
    });
    }
}
