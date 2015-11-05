<?php

namespace App\Models;

//un évènement n'est qu'un utilisateur avec comme role "event"

class Event extends UserWithHidden
{
	public function newQuery()
	{
		return parent::newQuery()->where("roles","like",'%"event"%');
	}
}
