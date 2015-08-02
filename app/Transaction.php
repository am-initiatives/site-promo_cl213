<?php

namespace App;

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
    protected $protected = ['credited_account_id', 'debited_account_id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['amount', 'wording', 'active'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];




    /**
     * Check if the account is active.
     *
     * @return bool|int
     */
    public function isActive()
    {
        return $this->active;
    }




    /**
     * Get the account that owns the transaction.
     */
    public function credited()
    {
        return $this->belongsTo('App\Account', 'credited_account_id');
    }

    /**
     * Get debits for the account.
     */
    public function debited()
    {
        return $this->belongsTo('App\Account', 'debited_account_id');
    }
}
