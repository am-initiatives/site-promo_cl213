<?php

namespace App\Models\Binders;

use App\Services\Binder;

use App\Models\User;


class UserBinder extends BaseBinder
{
	
	public function resolve($uid,$action)
	{
		return User::findOrFail($uid);
	}

	public function getParamsForAction($action,$user)
	{
		//tout le monde peut tout voir
		switch ($action) {
			case 'edit':
				return [
					"name"		=> "buquage",
					"owner_id"	=> $user->id
					];
				break;
			case 'createAppro':
			case 'storeAppro':
				return [
					"name"		=> "appro",
					"owner_id"	=> User::getBankAccount()->id
					];
				break;
			default:
				return null;
				break;
		}
	}
}