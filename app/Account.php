<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'accounts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'description', 'restricted', 'active'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];



    /**
     * Check if the account is restriced.
     *
     * @return bool|int
     */
    public function isRestricted()
    {
        return $this->restricted;
    }

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
     * Return current account balance.
     *
     * @return bool|int
     */
    public function transactions()
    {
        $credits = $this->credits;
        $debits = $this->debits;
        $transactions = $debits->merge($credits);

        return $transactions;
    }

    /**
     * Return current account balance.
     *
     * @return bool|int
     */
    public function balance()
    {
        return $this->credits->sum('amount') - $this->debits->sum('amount');
    }

    /**
     * Return current account history.
     *
     * @return bool|int
     */
    public function recap()
    {
        $transactions = $this->transactions();
        $transactions = $transactions->sortByDesc(function ($item, $key) {return $item->created_at;});

        $table = [];

        foreach ($transactions as $t) {
            $isCredit = ($this->id == $t->credited_account_id);
            $table[] = array(
                'type' => $isCredit ? 'credit' : 'debit',
                'date' => utf8_encode($t->created_at->formatLocalized('%d %B %Y &agrave; %H:%m')),
                'wording' => $t->wording,
                'amount' => ($isCredit ? '' : '-').$t->amount,
                'account' => $isCredit ? $t->debited->description : $t->credited->description,
                );
        }

        return $table;
    }


    /**
     * Get the user to whom belongs the account.
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * Get credits for the account.
     */
    public function credits()
    {
        return $this->hasMany('App\Transaction', 'credited_account_id');
    }

    /**
     * Get debits for the account.
     */
    public function debits()
    {
        return $this->hasMany('App\Transaction', 'debited_account_id');
    }
}