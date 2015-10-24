<?php

namespace App\Models\Binders;

use App\Services\Binder;

use Auth;

/**
* BaseBinder
*
* teste automatiquement les permissions à la résolution des éléments
*/

abstract class BaseBinder implements Binder
{
	public function bind($value,$route)
	{
		$action = preg_replace("/^[^@]*@/", "", $route->getActionName());

		$element = $this->resolve($value,$action);

		$params = $this->getParamsForAction($action,$element);

		if($params && !Auth::user()->isAllowed($action."_".$params["name"],$params["owner_id"])){
			abort(403);
		}

		return $element;
	}

	abstract public function getParamsForAction($action,$element);
	abstract public function resolve($value,$route);
}