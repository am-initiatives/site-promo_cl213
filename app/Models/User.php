<?php

namespace App\Models;

use Auth;

/**
* 	Utilisateurs normaux qui ne voient pas les comptes cachés
*/

class User extends UserWithHidden
{
	
	public function newQuery()
	{
		if (Auth::check() and Auth::user()->isAllowed('hidden_users')){ //authorise à voir les hidden
			return parent::newQuery();
		}
		elseif(Auth::check()){ //authorise à se voir soi-même
			return parent::newQuery()->whereRaw('(hidden=0 or id=?)',[Auth::user()->id]);
		}
		else{ //voit pas les cachés
			return parent::newQuery()->where('hidden', 0);
		}
	}
}