<?php

namespace App\Providers;

use App\Mixins\StrMixins;
use Illuminate\Support\Str;
use App\Mixins\MigrationMixin;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Blueprint;

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

        URL::defaults(['dashboardUrl' => 'dashboard']);
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
