<?php

namespace App\Providers;

use App\Mixins\MigrationMixin;
use App\Mixins\StrMixins;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Str::mixin(new StrMixins());
        Blueprint::mixin(new MigrationMixin());

        URL::defaults(['dashboardUrl' => 'home']);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }
}
