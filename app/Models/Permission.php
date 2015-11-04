<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Auth;

/**
* 	Utilisateurs normaux qui ne voient pas les comptes cachés
*/

class Permission extends Model
{
	protected $table = 'permissions';

	protected $fillable = ['role',"permission"];

	public function users()
	{
		return User::find("roles","like","%".$this->role."%");
	}

	public static function add($role,$permission)
	{
		return self::create([
			"role"			=> $role,
			"permission"	=> $permission
			]);
	}
}