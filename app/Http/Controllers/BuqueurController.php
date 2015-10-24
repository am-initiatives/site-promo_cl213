<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\User as User;

class BuqueurController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$data['accounts'] = User::all();

		return view('accounts.index', $data);
	}

	public function show($id)
	//liste des buquages à venir
	{
		$account = User::find($id);
		$data =  $account->recap();
		$data['solde'] = $account->getBalance();
		$data['user'] = $id;
		return view('accounts.show',$data);
	}

	public function details($id)
	{
		$account = User::find($id);
		$data['transactions'] = $account->transactionsDetail();
		$data['solde'] = $account->getBalance();

		return view('accounts.details', $data);
	}
}
