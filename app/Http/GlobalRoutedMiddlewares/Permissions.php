<?php

namespace App\Http\GlobalRoutedMiddlewares;

use Illuminate\Routing\Route;
use App\Services\GlobalRoutedMiddleware;

use Auth;
use Config;

/**
* Gère les accès lists, si par authorisé => redirection erreur 403
*/

class Permissions implements GlobalRoutedMiddleware
{
	private $ressourcesRoutes,$basicRoutes;
	
	function __construct()
	{
		$this->ressourcesRoutes = Config::get("permissions.ressources");
		$this->basicRoutes = Config::get("permissions.basic");
	}

	public function handle(Route $route)
	{
		if($this->hasPermission($route)){
			return $route;
		}
		else
		{
			abort(403);
		}
	}

	private function hasPermission($route)
	{
		$rname = $route->getName();

		if(isset($this->basicRoutes[$rname])){ //si on connait la route
			$routeAcl = $this->basicRoutes[$rname];

			$param = $route;

			if(isset($routeAcl["getTarget"])){ //si pas de getTarget on considère qu'on allow tjrs
				if(isset($routeAcl["param"])){
					$param = $route->parameters()[$routeAcl["param"]];
				}

				//set des params pour isAllowed
				$name = $routeAcl["name"];
				$target = $routeAcl["getTarget"]($param);
			}
			else
			{
				return true;
			}
		}

		if(!isset($name)) //si aucune route normal n'a matché
		{
			$endsWith = function($haystack, $needle) {
				// search forward starting from end minus needle length characters
				return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
			};

			foreach (["index","create","store","show","edit","update","destroy"] as $key) {
				if($endsWith($rname,$key)){
					$action=$key;
					break;
				}
			}

			if(isset($action)){ //si l'action correspond bien à une ressource REST
				$res = str_replace(".".$action, "", $rname);

				if(isset($this->ressourcesRoutes[$res])){ //si on connait cette route
					$routeAcl = $this->ressourcesRoutes[$res];
					if($routeAcl["isRestricted"]($action)){ //si on restreint bien cette route
						$params = $route->parameters();
						$params = $routeAcl["getTarget"](isset($params[$res]) ? $params[$res] : $route);

						$name = $action."_".$params["action"];
						$target = $params["target"];
					}
					else{
						return true;
					}
				}
			}
		}

		if(isset($name) && Auth::check()) //si on a matché une règle et qu'il faut faire un test
		{
			return Auth::user()->isAllowed($name,$target);
		}
		else
		{
			return false;
		}
	}
}