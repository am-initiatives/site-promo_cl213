<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use App\Traits\Validates;

use App;

abstract class Controller extends BaseController
{
	use DispatchesJobs, Validates;

	// liste des actions qui doient être régulées
	// seront alors appelées les fonctions
	// can<Action>($arg1,$arg2,...)
	// et si elle renvoie vrai, alors on appelle
	// execute<Action>($arg1,$arg2,...)

	protected $actions = [];

	private function isInParameters($class,$parameters)
	{
		foreach ($parameters as $key => $parameter) {
			if($parameter instanceof $class->name )
				return true;
		}
		return false;
	}

	private function resolveParameters(\ReflectionMethod $reflector,$parameters)
	{
		foreach ($reflector->getParameters() as $key => $parameter) {
			$class = $parameter->getClass();

			//le paramètre a-t-il déjà été résolu par laravel ?
			if($class && !$this->isInParameters($class,$parameters))
			{
				$instance = App::make($class->name);

				//a-t-on réussi à résoudre ?
				if($instance){
					//insertion du param
					array_splice($parameters, $key, 0, [$instance]);
				}
			}
		}

		return $parameters;
	}

	public function __call($method,$arguments)
	{
		if(in_array($method,$this->actions) 
			&& method_exists($this, "can".ucfirst($method))
			&& method_exists($this,"execute".ucfirst($method))){

			$reflector = new \ReflectionMethod($this, "can".ucfirst($method));
			$canArgs = $this->resolveParameters($reflector,$arguments);
			if(call_user_func_array([$this,"can".ucfirst($method)], $canArgs)){

				$reflector = new \ReflectionMethod($this, "execute".ucfirst($method));
				$execArgs = $this->resolveParameters($reflector,$arguments);
				return call_user_func_array([$this,"execute".ucfirst($method)], $execArgs);
			}
			else{
				abort(403);
			}
		}
		else{
			abort(404);
		}
	}
}
