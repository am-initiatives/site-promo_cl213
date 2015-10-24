<?php

namespace App\Services;

/**
 *
 * Charge le binder demandé
 *
 * Les binders permettent d'injecter directement un objet à la place 
 * de son identifiant lorsqu'on utilise une route du type user/{userid}
 *
 * L'idée c'est de faire toutes les validations dans les binders
 *
 */

class BindersLoader 
{
	const bindersDir = '\App\Models\Binders';
	
	public function get($binderName)
	{
		$classname = self::bindersDir.'\\'.ucfirst($binderName).'Binder';

		if(!class_exists($classname)){
			throw new \Exception('Class \''.$classname."' not found");
		}

		if(!in_array("App\Services\Binder", class_implements($classname))){
			throw new \Exception('Class \''.$classname."' not implementing App\Services\Binder");
		}

		$class = new $classname();

		return function($value,$route) use($class){
			return $class->resolve($value,$route);
		};
	}
}

interface Binder {
	public function resolve($value,$route);
}