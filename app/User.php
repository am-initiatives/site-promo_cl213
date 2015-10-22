<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use Illuminate\Database\Eloquent\SoftDeletes;

use App\Scopes\HiddenTrait;
use Auth;
use Hash;
use Carbon\Carbon;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, SoftDeletes;
    // use HiddenTrait;

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
    protected $fillable = ['password', 'email', 'phone', 'first_name', 'last_name', 'nickname', 'pos', 'google_info', 'info', 'active', 'permissions', 'connected_at'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token', 'google_id'];




    /**
     * Get a new query builder for the model's table.
     * Override de la méthode de base pour cacher les credentials
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    // public function newQuery()
    // {
    //     // Get previous calling functions to check that the function is not called recursively (ignoring the first which is the current one)
    //     $functions = array_column(array_slice(debug_backtrace(), 1), 'function');

    //     // dd($functions);

    //     // Autorise l'authentification à avoir accès aux utilisateurs cachés.
    //     if (in_array('retrieveByCredentials', $functions) or in_array('retrieveById', $functions) or in_array('getLoginWithGoogle', $functions)) {
    //         return parent::newQuery()->withHidden();
    //     // La partie au dessus est nécessaire pour que la partie ci-dessous fonctionne ! sinon ajouter "! in_array('newQuery', $functions) and"
    //     } elseif (Auth::check() and Auth::user()->isAllowed('hidden_users'))
    //         return parent::newQuery()->withHidden();
    //     else {
    //         return parent::newQuery();
    //     }
    // }


    public static function getPositions()
    {
        $users = self::whereNotNull('pos')->get();

        $positions = [];

        foreach ($users as $user) {
            $position = $user->getPosition();

            $positions[] = [
                $user->getTitle(),
                $position[0],
                $position[1],
            ];
        }

        return $positions;
    }


    public function setPassword($request) {
        $password = $request->input('password');
        $password_confirmation = $request->input('password_confirmation');

        if ($password == $password_confirmation) {
            $this->updated_at = Carbon::now();
            $this->password = Hash::make($password);
            $this->save();

            return true;
        }

        return false;
    }



    public function isFirstConnection() {
        return is_null($this->updated_at);
    }


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
            return User::all();
        else
        {
            $available = User::where('permissions','not like', "%restricted%")->get();

            if ($user_account = $this->account)
                $available = $available->push($user_account);

            return $available;
        }
    }

    public function isAllowed($required, $user_id = null)
    {
        if ($user_id == $this->id) {
            return true;
        } elseif (is_null($required)) {
            return false;
        }

        $permissions = $this->permissions();

        return in_array($required, $permissions) or in_array('admin', $permissions);
    }




    public function getGoogleInfo()
    {
        if ($this->google_info) {
            $info = json_decode($this->google_info, true);
            return $info;
        } else {
            return null;
        }
    }


    public function getPictureLink()
    {
        if ($this->picture) {
            return url('uploads/pictures',$this->picture);
        } else if ($google_info = $this->getGoogleInfo() and isset($google_info['picture'])) {
            return $google_info['picture'];
        } else {
            return url('images/default_picture.png');
        }
    }


    public function getTitle()
    {
        if ($this->nickname == '')
            return $this->first_name . ' ' . $this->last_name;
            return $this->nickname;
    }

    public function getLink()
    {
        return route('users.show', $this->id);
    }

    public function getLinkTitle()
    {
        return '<a href="'.$this->getLink().'">'.$this->getTitle().'</a>';
    }

    public function getPosition()
    {
        return json_decode($this->pos, true);
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
     * Get the user to whom belongs the account.
     */
    public function user()
    {
        return $this->hasMany('App\Post', 'user_id');
    }




    /*================================================
    =            Gestion des transactions            =
    ================================================*/





    public function isRestricted()
    //restricted : on peut pas lui prendre des sous
    {
        return in_array($required, $permissions) or in_array('restricted', $permissions);
    }


    public function getBalance()
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
        $transactions = $this->getTransactions();
        $transactions = $transactions->sortByDesc(function ($item, $key) {return $item->created_at;});

        $table = [];

        foreach ($transactions as $t) {
            $isCredit = ($this->id == $t->credited_user_id);
            $table[] = array(
                'type' => $isCredit ? 'credit' : 'debit',
                'date' => utf8_encode($t->created_at->formatLocalized('%d %B %Y &agrave; %H:%m')),
                'wording' => $t->wording,
                'amount' => ($isCredit ? '' : '-').$t->amount,
                'account' => $isCredit ? $t->debited->nickname : $t->credited->nickname,
                );
        }

        return $table;
    }

    /**
     * Return current account transactions.
     *
     * @return bool|int
     */
    public function getTransactions()
    {
        $credits = $this->credits;
        $debits = $this->debits;
        $transactions = $debits->merge($credits);

        return $transactions;
    }

    /**
     * Get credits for the account.
     */
    public function credits()
    {
        return $this->hasMany('App\Transaction', 'credited_user_id')->acquited();
    }

    /**
     * Get debits for the account.
     */
    public function debits()
    {
        return $this->hasMany('App\Transaction', 'debited_user_id')->acquited();
    }

    /*=====  End of Gestion des transactions  ======*/
    
    
}
