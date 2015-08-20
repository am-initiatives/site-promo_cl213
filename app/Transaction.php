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
    protected $protected = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['credited_account_id', 'debited_account_id', 'amount', 'wording', 'active'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];




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
