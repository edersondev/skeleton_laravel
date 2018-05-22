<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AssetsServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->publishes([
			base_path() . '/vendor/components/jquery' => public_path('components/jquery'),
			base_path() . '/vendor/ckeditor/ckeditor' => public_path('components/ckeditor'),
			base_path() . '/vendor/components/chosen' => public_path('components/chosen'),
			base_path() . '/vendor/datatables/datatables' => public_path('components/datatables'),
			base_path() . '/vendor/eternicode/bootstrap-datepicker' => public_path('components/bootstrap-datepicker'),
			base_path() . '/vendor/igorescobar/jquery-mask-plugin' => public_path('components/jquery-mask-plugin'),
			base_path() . '/vendor/moment/moment' => public_path('components/moment'),
			base_path() . '/vendor/pnikolov/bootbox' => public_path('components/bootbox'),
			base_path() . '/vendor/twbs/bootstrap' => public_path('components/bootstrap'),
			base_path() . '/vendor/FezVrasta/popper' => public_path('components/popper'),
			base_path() . '/vendor/almasaeed2010/AdminLTE' => public_path('components/adminlte'),
			base_path() . '/vendor/FortAwesome/Font-Awesome' => public_path('components/fortawesome'),
		],'app_assets');
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
