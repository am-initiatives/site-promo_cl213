<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['password', 'email', 'phone', 'given_name', 'last_name', 'surname', 'information', 'active', 'permissions'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token', 'google_id'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];





    private function permissions()
    {
        if ( $permissions = @json_decode($this->permissions, true) )
            return $permissions;
        else
            return [];
    }



    /**
     * Check if the user is active.
     *
     * @return bool|int
     */
    public function isActive()
    {
        return $this->active;
    }


    public function availableAccounts()
    {
        if ($this->isAllowed('all_accounts'))
            return Account::all();
        else
        {
            $available = Account::where('restricted', 0)->get();

            if ($user_account = $this->account)
                $available = $available->push($user_account);

            return $available;
        }
    }

    public function isAllowed($required)
    {
        $permissions = $this->permissions();

        if (in_array('admin', $permissions))
            return true;

        return in_array($required, $permissions);
    }





    /**
     * Scope a query to only include visible users.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVisible($query)
    {
        return $query->where('hidden', 0);
    }





    /**
     * Get account of the user.
     */
    public function account()
    {
        return $this->hasOne('App\Account', 'user_id');
    }
}
