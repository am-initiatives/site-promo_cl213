<?php

namespace App\Services\Facades;

use Illuminate\Support\Facades\Facade;

/**
* Facade pour le services de résolution des binders : BindersLoader
*/
class BindersFacade extends Facade
{
	 protected static function getFacadeAccessor() { return 'binders'; }
}