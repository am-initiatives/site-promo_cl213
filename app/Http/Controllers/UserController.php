<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\User;

class UserController extends Controller
{

	public function index()
	{
		$data['users'] = User::all();

		return view('users.index', $data);
	}

	public function show($user)
	{
		$data['user'] = $user;

		return view('users.show', $data);
	}

	public function parameters($user)
	{
		return view('users.parameters')->with("user",$user);
	}

	/*============================================
	=            Vues des comptes PGs            =
	============================================*/

	public function accounts()
	{
		$data['accounts'] = User::all();

		return view('users.accounts.index', $data);
	}

	public function account($account)
	//liste des buquages présents et à venir
	{
		$data =  $account->recap();
		$data['solde'] = $account->getBalance();
		$data['user'] = $account;
		return view('users.accounts.show',$data);
	}

	public function accountDetails($account)
	//liste des transactions effectuées
	{
		return view('users.accounts.details')
			->withUser($account)
			->withTransactions($account->transactionsDetail());
	}
}
