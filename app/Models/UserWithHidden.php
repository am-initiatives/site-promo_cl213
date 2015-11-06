<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use Auth;
use Hash;
use Carbon\Carbon;
use DB;

class UserWithHidden extends Model implements AuthenticatableContract, CanResetPasswordContract
{
	use Authenticatable, CanResetPassword;

	const Bank = "Banque";

	//The database table used by the model.
	protected $table = 'users';

	//The attributes that are mass assignable.
	protected $fillable = ['password', 'email', 'phone', 'first_name', 'last_name', 'nickname', 'pos', 'google_pic', 'info', 'active', 'permissions', 'connected_at'];

	//The attributes excluded from the model's JSON form.
	protected $hidden = ['password', 'remember_token', 'google_id'];

	//Permet d'utiliser carbon sur les dates suivantes
	protected $dates = ['connected_at'];


	public static function getBankAccount()
	{
		$bank = UserWithHidden::where("nickname",self::Bank)->first();

		if(!$bank){
			throw new \Exception("Error no bank account found with name : ".self::Bank, 1);
		}

		return $bank;
	}
	
	public function getPictureLink()
	{
		if ($this->picture) {
			return url('uploads/pictures',$this->picture);
		} else if ($this->google_pic) {
			return $this->google_pic;
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

	/*===================================
	=            Permissions            =
	===================================*/

	public function isAllowed($required, $user_id = null)
	//est authorisé à faire "required" à "user_id" ?
	{
		//on peut se faire ce qu'on veut
		if ($user_id == $this->id) {
			return true;
		//tant que ce n'est pas rien (debug)
		} elseif (is_null($required)) {
			return false;
		}


		//check des permissions

		return $this->hasPermission($required) or $this->hasPermission('all');
	}

	public function hasPermission($perm)
	{
		if ( $roles = @json_decode($this->roles, true) ){
			foreach ($roles as $role) {
				if(Permission::where("role",$role)->where("permission",$perm)->count()!=0){
					return true;
				}
			}
			return false;
		}
		else{
			return false;
		}
	}

	public function hasRole($role)
	{
		return in_array($role, @json_decode($this->roles, true));
	}

	public function addRole($role)
	{
		$roles = @json_decode($this->roles, true);

		if(!in_array($role, $roles)){ //si on n'a pas déjà ce role
			$roles[] = $role;
			$this->roles = @json_encode($roles,true);
			return $this->update();
		}

		return true;
	}
	
	/*=====  End of Permissions  ======*/
	

	/*===========================================
	=            Gestion de la carte            =
	===========================================*/

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

	public function getPosition()
	{
		return json_decode($this->pos, true);
	}

	/*=====  End of Gestion de la carte  ======*/
	

	/*================================================
	=			Gestion des transactions			=
	================================================*/

	public function getBalance()
	{
		return intval($this->credits()->acquited()->sum('amount') - $this->debits()->acquited()->sum('amount'));
	}

	public function spendings()
	{
		return intval($this->debits()->acquited()->sum('amount'));
	}

	public function gains()
	{
		return intval($this->credits()->acquited()->sum('amount'));
	}

	public function transactionsDetail()
	//historique des transactions effectuées
	{

		$credits = $this->credits()->acquited()->get();
		$debits = $this->debits()->acquited()->get();
		$transactions = $debits->merge($credits);

		$transactions = $transactions->sortByDesc(function ($item, $key) {return $item->created_at;});

		$table = [];

		foreach ($transactions as $t) {
			$table[] = $t->format($this);
		}

		return $table;
	}

	public function recap()
	//recap des crédits à venir et effectués sous forme de groupes
	{
		$data=["debits"=>[],"credits"=>[]];

		/**
		 *
		 * credits
		 *
		 */
		

		//récupère les groupes de buquages
		$groups = DB::table("transactions")
			->select('group_id')
			->where('credited_user_id',$this->id)
			->whereNull('deleted_at')
			->groupBy('group_id')
			->orderBy('created_at','desc')->get();

		//remplit les groupes
		foreach($groups as $record)
		{
			$group =[];
			$nb = 0;
			$acquited = 0;
			$gpeTransactions = Transaction::where("group_id",$record->group_id)
				->orderBy("state")
				->get();
			foreach ($gpeTransactions as $t) {
				$group["rows"][] = $t->format($this);
				if($t->state=="acquited")
					$acquited++;
				$nb++;
			}
			$group["wording"] = $group["rows"][0]["wording"];
			$group["amount"] = $group["rows"][0]["amount"];
			$group["total"] = $nb;
			$group["acquited"] = $acquited;

			$data["credits"][$record->group_id] = $group;
		}

		/**
		 *
		 * debits
		 *
		 */
		
		foreach ($this->debits()->orderBy('created_at','desc')->get() as $t) {
			 $data["debits"][] = $t->format($this);
		}
	   
		return $data;
	}

	/*=====  End of Gestion des transactions  ======*/

	/*=================================
	=            Relations            =
	=================================*/

	public function credits()
	//crédits actifs
	{
		return $this->hasMany('App\Models\Transaction', 'credited_user_id');
	}

	public function debits()
	//débits actifs
	{
		return $this->hasMany('App\Models\Transaction', 'debited_user_id');
	}


	public function posts()
	{
		return $this->hasMany('App\Models\Post', 'user_id');
	}

	/*=====  End of Relations  ======*/
	
	
}
