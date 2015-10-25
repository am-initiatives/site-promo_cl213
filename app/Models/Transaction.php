<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
	use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'transactions';

	/**
	 * The attributes that are not mass assignable.
	 *
	 * @var array
	 */
	protected $protected = [];

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['credited_user_id', 'debited_user_id', 'amount', 'wording', 'active','group_id','state'];

	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = ['deleted_at'];

	public function format($user)
	{
		$isCredit = ($user->id == $this->credited_user_id);
		$date = $this->state=="acquited" ? $this->updated_at : $this->created_at;
		return array(
			'id'		=> $this->id,
			'type'	  => $isCredit ? 'credit' : 'debit',
			'date'	  => utf8_encode($date->formatLocalized('%d %B %Y &agrave; %H:%m')),
			'wording'   => $this->wording,
			'amount'	=> ($isCredit ? '' : '-').$this->amount,
			'account'   => $isCredit ? $this->debited->nickname : $this->credited->nickname,
			'state'	 => $this->state,
			);
	}


	/**
	 * Get the account that owns the transaction.
	 */
	public function credited()
	{
		return $this->belongsTo('App\Models\UserWithHidden', 'credited_user_id');
	}

	/**
	 * Get debits for the User.
	 */
	public function debited()
	{
		return $this->belongsTo('App\Models\UserWithHidden', 'debited_user_id');
	}


	

	public function scopeAcquited($query)
	{
		return $query->whereState("acquited");
	}

	public function scopePending($query)
	{
		return $query->whereState('pending');
	}
}
