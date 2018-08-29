<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer("layouts.app","App\Http\ViewComposers\SidebarComposer");
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
