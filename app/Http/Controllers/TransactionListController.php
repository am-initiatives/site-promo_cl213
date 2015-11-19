<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Validator;

use App\Models\User as User;
use App\Models\Transaction as Transaction;
use App\Services\Factories\TransactionFactory;

use Ramsey\Uuid\Uuid;

use DB;

class TransactionListController extends Controller
{
	public function index(){}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$debitables = User::all();

		foreach ($debitables as $c) {
			$data['debitables'][$c->id] = $c->getTitle();
		}

		return view('transactionlist.create', $data);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request,TransactionFactory $factory)
	{
		$redirect = function($validator) {
			return redirect()->route('transactions.create')
				->withErrors($validator)
				->withInput();
			};

		$validator = Validator::make($request->all(), [
			'debited' => 'required|array',
		]);

		if ($validator->fails()) {
			return $redirect($validator);
		}

		$uuid = Uuid::uuid4()->toString() ; //identifiant de la facture

		DB::beginTransaction();

		foreach ($request->get("debited") as $debited) {
			$validator = null;
			$validator = $factory->build([
				'wording'		   => $request->get('wording'),
				'amount'			=> $request->get('amount'),
				'debited_user_id'   => $debited,
				'group_id'		  => $uuid,
				]);

			if($validator){
				DB::rollback();
				return $redirect($validator);
			}
		}

		DB::commit();

		return redirect()->route('users.account.show',Auth::user()->id)->with("credit_tab",true);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Request $r,$group)
	//vue pour ajouter une personne après coup
	{
			$t = clone $group;
			$t = $t->first();
			$uid = $t->credited_user_id;

			$debitables = User::all();

			$data['debitables'] = [];

			//consturction de la liste "id"=>"Nom" pour le select
			foreach ($debitables as $c) {

				if($c->id == $uid)
					//on eclut l'utilisateur
					continue;

				$data['debitables'][$c->id] = $c->getTitle();
			}

			//on vire les gens qui y sont déjà
			foreach ($group->get() as $nonDebitable) {
				unset($data["debitables"][$nonDebitable->debited_user_id]);
			}

			$data["wording"] = $t->wording;
			$data["amount"] = $t->amount;
			$data["group_id"] = $t->group_id;

			return view("transactions.lists.edit",$data);
	}

	public function update(Request $request, $group,TransactionFactory $factory)
	//ajouter une personne après coup
	{
		$redirect = function($validator,$id){
			return redirect()->route('transactionlist.edit',$id)
						->withErrors($validator)
						->withInput();
		};

		$validator = Validator::make($request->all(), [
			'debited' => 'required|array'
		]);

		$t = $group->first();
		$id = $t->group_id;

		if ($validator->fails()) {
			return $redirect($validator,$id);
		}

		DB::beginTransaction();

		foreach ($request->get("debited") as $debited) {
			$validator = null;
			$validator = $factory->build(array(
				'wording'		   => $t->wording,
				'amount'			=> $t->amount,
				'credited_user_id'  => $t->credited_user_id,
				'debited_user_id'   => $debited,
				'group_id'		  => $id
				));

			if ($validator) {
				DB::rollback();
				return $redirect($validator,$id);
			}
		}

		DB::commit();

		return redirect()->route('users.account.show',[$t->credited_user_id])->with("credit_tab",true);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($group)
	{
		$uid = $group->first()->credited_user_id;

		$group->each(function($t) {$t->delete();});

		return redirect()->route('users.account.show',[$uid])->with("credit_tab",true);
	}

	public function createAppro()
	{
		return view("transactions.lists.appro")->with("creditables",User::all());
	}

	public function storeAppro(Request $request,TransactionFactory $factory)
	{
		$redirect = function($validator) {
			return redirect()->route('transactionlist.appro.create')
				->withErrors($validator)
				->withInput();
			};

		$validator = Validator::make($request->all(), [
			'credited' => 'required|array',
		]);

		if ($validator->fails()) {
			return $redirect($validator);
		}

		DB::beginTransaction();

		foreach ($request->get("credited") as $uid) {
			$validator = null;
			$validator = $factory->buildAppro($request->get("wording"),$request->get("amount"),$uid);

			if($validator){
				DB::rollback();
				return $redirect($validator);
			}
		}

		DB::commit();

		return redirect()->route('users.accounts')->withErrors(["ok"=>count($request->get("credited"))." Utilisateurs Crédités"]);
	}
}
