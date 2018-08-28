<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::component('components.form.form_buttons', 'form_buttons');
        Blade::component('components.bootstrap.modal_confirm', 'modal_confirm');
        Blade::component('components.js.modal_confirm_action', 'modal_confirm_action');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
