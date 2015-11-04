<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'events';

	/**
	 * The attributes that are not mass assignable.
	 *
	 * @var array
	 */
	protected $protected = [];

	protected $fillable = ['name','description','picture'];

	public function account()
	{
		return $this->belongsTo('App\Models\UserWithHidden',"user_id");
	}
}
