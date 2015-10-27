<?php

namespace App\Services;

use Illuminate\Routing\Router;
use Illuminate\Routing\Route;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Container\Container;

use App;
use Config;
/**
* RouterHook
*
* Surcharge du routeur de base pour appeler les GlobalRoutedMiddlewares après avoir bindé les models
*
* http://blog.lanin.me/2015/10/03/extending-default-laravel-router/
*/

class RouterHook extends Router
{
	private $middlewares;

	function __construct(Dispatcher $events, Container $container = null){
		parent::__construct($events,$container);

		$this->middlewares = Config::get("app.globalmiddlewares");

		//validation des infos
		foreach ($this->middlewares as $name => $classname) {
			if(!class_exists($classname)){
				throw new \Exception('Class \''.$classname."' not found");
			}

			if(!in_array("App\Services\GlobalRoutedMiddleware", class_implements($classname))){
				throw new \Exception('Class \''.$classname."' not implementing App\Services\GlobalRoutedMiddleware");
			}
		}
	}

	//override de la fonction de base après binding des models
	protected function findRoute($request)
	{
		$route = parent::findRoute($request);

		foreach ($this->middlewares as $name => $value) {
			App::make($name)->handle($route);
		}

		return $route;
	}

}

interface GlobalRoutedMiddleware {
	public function handle(Route $route);
}