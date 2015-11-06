<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;

use App\Models\User as User;
use App\Models\Transaction as Transaction;
use App\Services\Factories\TransactionFactory;

use Ramsey\Uuid\Uuid;

use DB;

class TransactionController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$transactions = Transaction::acquited()
			->orderBy('created_at', 'desc')
			->get();

		$table = [];

		foreach ($transactions as $t) {
			$table[] = $t->format();
		}

		$data['transactions'] = $table;

		return view('transactions.index', $data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$data['debitables'] = [];

		//consturction de la liste "id"=>"Nom" pour le select
		foreach ( User::all() as $c) {

			if($c->id == Auth::user()->id)
				//on eclut l'utilisateur
				continue;

			$data['debitables'][$c->id] = $c->getTitle();
		}

		return view('transactions.create', $data);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function store(Request $request,TransactionFactory $factory)
	{
		if($validator = $factory->build($request->all()))
		{
			return redirect()->route('transactions.create')
						->withErrors($validator)
						->withInput();
		}

		return redirect()->route('users.account.show',Auth::user()->id)->with("credit_tab",true);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  Request  $request
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $t)
	//utilisé pour la validation d'un buquage
	{
		$t->state = "acquited";
		$t->update();

		return redirect()->route('users.account.show',[$request->get("user")]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(Request $request,$t)
	{
		$uid = $t->credited_user_id;
		$t->delete();

		if($t->credited_user_id == User::getBankAccount()){
			return redirect()->back;
		}

		return redirect()->back()->with("credit_tab",true);
	}

	public function createAppro($user)
	//paramètre $user présent pour pouvoir buquer quelqu'un d'autre que soi
	{
		return view("transactions.appro")->with("user",$user);
	}

	public function storeAppro(Request $request,TransactionFactory $factory,$user)
	{
		$validator = $factory->buildAppro($request->get("wording"),$request->get("amount"),$user);

		if ($validator) {
			return redirect()->route('transactions.appro.create',$user)
						->withErrors($validator)
						->withInput();
		}

		return redirect()->route('users.account.show',[$user->id])->with("credit_tab",true);
	}

	public function createOutgo()
	{
		return view("transactions.outgo");
	}

	public function storeOutgo(Request $request,TransactionFactory $factory)
	{
		$user = Auth::user();
		$validator = $factory->build([
			"wording"	=> $request->get("wording"),
			"amount"	=> $request->get("amount"),
			"credited_user_id"	=> User::getBankAccount()->id,
			"debited_user_id"	=> $user->id,
			"state"		=> "acquited",
			]);

		if ($validator) {
			return redirect()->route('transactions.outgo.create',$user)
						->withErrors($validator)
						->withInput();
		}

		return redirect()->route('users.account.show',[$user->id]);
	}
}
