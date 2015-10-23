<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;

use App\User as User;
use App\Transaction as Transaction;

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
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function createList()
	{
		$debitables = Auth::user()->availableAccounts();
		$creditables = User::all();

		$data['creditables'] = [];
		$data['debitables'] = [];

		foreach ($creditables as $c) {
			$data['creditables'][$c->id] = $c->getTitle();
		}
		foreach ($debitables as $c) {
			$data['debitables'][$c->id] = $c->getTitle();
		}

		return view('transactions.lists.create', $data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function listTables(Request $request)
	{
		$tables = $request->all();

		$data['debited'] = [];
		$data['credited'] = [];

		if (isset($tables['debited'])) {
			$ids = array_keys($tables['debited']);
			$debited = User::find($ids);

			foreach ($tables['debited'] as $id => $amount) {
				$d = $debited->only($id)->first();
				$data['debited'][] = array(
					'id' => $id,
					'title' => $d->getTitle(),
					'amount' => $amount,
				);
			}
		}

		if (isset($tables['credited'])) {
			$ids = array_keys($tables['credited']);
			$credited = User::find($ids);

			foreach ($tables['credited'] as $id => $amount) {
				$d = $credited->only($id)->first();
				$data['credited'][] = array(
					'id' => $id,
					'title' => $d->getTitle(),
					'amount' => $amount,
				);
			}
		}

		return view('transactions.lists.tables', $data);
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
			'wording'           => $request->get('wording'),
			'amount'            => (integer) 100*$request->get('amount'),
			'credited_user_id'  => Auth::user()->id,
			'debited_user_id'   => $request->get('debited'),
			'group_id'          => Uuid::uuid4(),
			);

		Transaction::create($data);

		return redirect()->route('transactions.index');
	}

	public function storeList(Request $request)
	{
		
		$validator = Validator::make($request->all(), [
			'debited' => 'required|array',
			'wording' => 'required|between:5,255',
			'amount' => 'required|numeric',
		]);

		if ($validator->fails()) {
			return redirect()->route('transactions.create')
						->withErrors($validator)
						->withInput();
		}

		$uuid = Uuid::uuid4()->toString() ; //identifiant de la facture

		DB::transaction(function() use ($request,$uuid)
		{
			foreach ($request->get("debited") as $debited) {
				$data = array(
					'wording'			=> $request->get('wording'),
					'amount'			=> (integer) 100*$request->get('amount'),
					'credited_user_id'	=> Auth::user()->id,
					'debited_user_id'	=> $debited,
					'group_id'			=> $uuid,
					);

				Transaction::create($data);
			}
		});

		return redirect()->route('transactions.show',[Auth::user()]);
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
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
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
	public function destroy($id)
	{
		//
	}
}
