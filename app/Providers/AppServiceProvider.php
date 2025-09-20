<?php

namespace App\Providers;

use App\Models\SchoolYear;

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

            $current = SchoolYear::where('first_quarter_start', '<=', $this)
                ->where('fourth_quarter_end', '>=', $this)
                ->first();

            if ($current) {
                return $current;
            }

            // fallback: get the latest school year by fourth_quarter_end
            return SchoolYear::orderBy('fourth_quarter_end', 'desc')->first();
        });
    }
}
