<?php

namespace App\Services;

use App\Models\UserWithHidden;

use Auth;
use Session;

/**
* Permet de se logguer en tant que quelqu'un d'autre
*/
class Impersonator
{
	public function isImpersonating()
	{
		return Session::has('loggedAs');
	}

	public function removeImpersonation()
	{
		return Auth::login(Session::pull('loggedAs'));
	}

	public function impersonate(UserWithHidden $impersonalized)
	{
		$user = Auth::user();
		Auth::login($impersonalized);
		Session::put("loggedAs",$user);
	}
}