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
		$action = substr($route->getCompiled()->getTokens()[0][1],1);

		$element = $this->resolve($value,$action);

		$params = $this->getParamsForAction($action,$element);

		if($params && !Auth::user()->isAllowed($action."_".$params["name"],$params["owner_id"])){
			abord(403);
		}

		return $element;
	}

	abstract public function getParamsForAction($action,$element);
	abstract public function resolve($value,$route);
}