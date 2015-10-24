<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;

use App\Models\User as User;
use App\Models\Transaction as Transaction;

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
		$transactions = Transaction::orderBy('created_at', 'desc')->get();

		$table = [];

		foreach ($transactions as $t) {
			$table[] = array(
				'date' => utf8_encode($t->created_at->diffForHumans()),
				'wording' => $t->wording,
				'amount' => $t->amount,
				'credited' => $t->credited->nickname,
				'debited' => $t->debited->nickname,
				);
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
		$debitables = Auth::user()->availableAccounts();

		$data['debitables'] = [];

		//consturction de la liste "id"=>"Nom" pour le select
		foreach ($debitables as $c) {

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
	public function store(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'debited' => 'required|integer|not_in:'.Auth::user()->id,
			'wording' => 'required|between:5,255',
			'amount' => 'required|numeric',
		]);

		if ($validator->fails()) {
			return redirect()->route('transactions.create')
						->withErrors($validator)
						->withInput();
		}

		$data = array(
			'wording'		   => $request->get('wording'),
			'amount'			=> (integer) 100*$request->get('amount'),
			'credited_user_id'  => Auth::user()->id,
			'debited_user_id'   => $request->get('debited'),
			'group_id'		  => Uuid::uuid4(),
			'state'				=> "pending"
			);

		Transaction::create($data);

		return redirect()->route('transactions.index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$account = User::find($id);
		$data['transactions'] = $account->transactionsDetail();
		$data['solde'] = $account->getBalance();

		return view('transactions.show', $data);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  Request  $request
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	//utilisé pour la validation d'un buquage
	{

		if($t = Transaction::find($id)){
			if(Auth::user()->isAllowed("acquit_buquage",$t->debited_user_id))
			{
				$t->state = "acquited";
				$t->update();
			}
		}

		return redirect()->route('accounts.show',[$request->get("user")]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(Request $request,$id)
	{
		$uid=null;
		if($t = Transaction::find($id)){
			$uid = $t->credited_user_id;
			if(Auth::user()->isAllowed("delete_buquage",$t->credited_user_id))
			{
				$t->delete();
			}
		}

		return redirect()->route('accounts.show',[$uid])->with("credit_tab",true);
	}
}
