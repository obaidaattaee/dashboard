<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
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
    public function boot()
    {

        Schema::defaultStringLength(191);

        if (Schema::hasTable('settings')) {

            Cache::forget('settings');
            $settings = Cache::remember('settings', 60, function () {
                return Setting::pluck( 'value' , 'key')->toArray();
            });

            config()->set('settings', $settings);
        }
    }
}
