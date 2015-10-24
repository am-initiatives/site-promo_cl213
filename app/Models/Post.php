<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
	use SoftDeletes;
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'posts';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['user_id', 'category', 'title', 'body'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [];

	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = ['deleted_at'];



	public function showBody()
	{
		$body = htmlentities($this->body);

		$rules = array(
			'[*]{1}' => 'strong',
			'[_]{1}' => 'i',
			);

		foreach ($rules as $rule => $tag) {
			$body = preg_replace("#$rule(.+?)$rule#", "<$tag>$1</$tag>", $body);
		}

		return nl2br($body);
	}

	/**
	 * Get the user to whom belongs the account.
	 */
	public function user()
	{
		return $this->belongsTo('App\Models\User', 'user_id')->withTrashed();//->withHidden();
	}
}
