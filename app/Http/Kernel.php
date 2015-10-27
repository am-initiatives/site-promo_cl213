<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
	/**
	 * The application's global HTTP middleware stack.
	 *
	 * @var array
	 */
	protected $middleware = [
		\Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
		\App\Http\Middleware\EncryptCookies::class,
		\Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
		\Illuminate\Session\Middleware\StartSession::class,
		\Illuminate\View\Middleware\ShareErrorsFromSession::class,
		// \App\Http\Middleware\VerifyCsrfToken::class,
	];

	/**
	 * The application's route middleware.
	 *
	 * @var array
	 */
	protected $routeMiddleware = [
		'auth' => \App\Http\Middleware\Authenticate::class,
		'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
		'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,

		'active' => \App\Http\Middleware\Activate::class,
	];

	/**
	 * Get the route dispatcher callback.
	 * hack pour override le router
	 * @return \Closure
	 */
	protected function dispatchToRouter()
	{
		$this->router = $this->app['router'];
		
		foreach ($this->routeMiddleware as $key => $middleware)
		{
			$this->router->middleware($key, $middleware);
		}

		return parent::dispatchToRouter();
	}
}
