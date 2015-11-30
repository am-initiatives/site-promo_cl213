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

		$url_rule = '(?:http|ftp|https)://(?:[\w+?\.\w+])+(?:[a-zA-Z0-9\~\!\@\#\$\%\^\&\*\(\)_\-\=\+\\\/\?\.\:\;\'\,]*)?';

		// Défini les règles de reformattages
		$rules = array(
			'[*]{1}(.+?)[*]{1}' => '<strong>$1</strong>',
			'[_]{1}(.+?)[_]{1}' => '<i>$1</i>',
			$url_rule => '<a href="$0" target="_blank">$0</a>',
			);

		// Ajoute le formattage
		foreach ($rules as $regex => $replacement) {
			$body = preg_replace("#".$regex."#", $replacement, $body);
		}

		// Sépare les paragraphes
		$body = "<p>" . preg_replace("#\r\n?|\n#", "</p><p>", $body) . "</p>";

		return $body;
	}

	/**
	 * Get the user to whom belongs the account.
	 */
	public function user()
	{
		return $this->belongsTo('App\Models\UserWithHidden', 'user_id');
	}
}
