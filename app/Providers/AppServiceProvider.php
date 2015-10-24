<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\BindersLoader;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('binders', function()
		{
		    return new BindersLoader();
		});
	}
}
