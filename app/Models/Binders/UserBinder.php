<?php

namespace App\Models\Binders;

use App\Services\Binder;

use App\Models\User;

class UserBinder implements Binder
{
	
	public function resolve($value,$route)
	{
		return new User();
	}
}