<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;

use App\Models\User as User;
use App\Models\Transaction as Transaction;
use App\Services\Factories\TransactionFactory;

use Ramsey\Uuid\Uuid;

use DB;

class TransactionListController extends Controller
{
	public function show($group)
	{
		$data = [
			'list_alert' => false,
		];

		// $data['credited'] = $group->first()->credited;
		// $data['amount'] = $group->first()->amount;

		// foreach ($group as $transaction) {
		// 	if ($data['credited']->id != $transaction->credited_user_id or $data['amount'] != $transaction->amount)
		// 		$data['list_alert'] = true;

		// 	$data['debits'][] = $transaction->format();
		// }

		// /!\ Fait à partir de la fonction User()->recap()

		$total = 0;
		$acquited = 0;
		$list = [];

		$group_id = $group->first()->group_id;

		foreach ($group->sortBy('state') as $transaction) {
			$list["debits"][] = $transaction->format($transaction->credited);
			if($transaction->state=="acquited")
				$acquited++;
			$total++;
		}

		// Récupère les informations générales
		$list["wording"] = $list["debits"][0]["wording"];
		$list["amount"] = $list["debits"][0]["amount"];
		$list["total"] = $total;
		$list["acquited"] = $acquited;

		$list['credit'] = $transaction->format($transaction->debited);

		$data["list"] = $list;
		$data['gpe'] = $group_id;

		return view('transactions.lists.show', $data);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request,TransactionFactory $factory)
	{
		$this->validate($request,[
			'debited' => 'required|array',
		]);

		$uuid = Uuid::uuid4()->toString() ; //identifiant de la facture

		DB::transaction(function() use ($request,$factory,$uuid){
			foreach ($request->get("debited") as $debited) {
				$factory->build([
					'wording'		   	=> $request->get('wording'),
					'amount'			=> $request->get('amount'),
					'debited_user_id'   => $debited,
					'group_id'		  	=> $uuid,
					'force'				=> $request->get("force")
					]);
			}
		});

		return redirect()->route('users.account.show',Auth::user()->id)->with("credit_tab",true);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Request $request, $group)
	//vue pour ajouter une personne après coup
	{
			$t = $group->first();
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
			foreach ($group as $nonDebitable) {
				unset($data["debitables"][$nonDebitable->debited_user_id]);
			}

			$data["wording"] = $t->wording;
			$data["amount"] = $t->amount;
			$data["group_id"] = $t->group_id;

			return view("transactions.lists.edit",$data)->withUser(Auth::user());
	}

	public function update(Request $request, $group, TransactionFactory $factory)
	//ajouter une personne après coup
	{
		$this->validate($request, [
			'debited' => 'required|array'
		]);

		$t = $group->first();
		$id = $t->group_id;

		DB::transaction(function() use ($t,$id,$factory,$request){
			foreach ($request->get("debited") as $debited) {
				$factory->build(array(
					'wording'		   	=> $t->wording,
					'amount'			=> $t->amount / 100,
					'credited_user_id'  => $t->credited_user_id,
					'debited_user_id'   => $debited,
					'group_id'		 	=> $id,
					'force'				=> $request->get("force")
					));
			}
		});

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

		DB::beginTransaction();

		$group->each(function($t) {$t->delete();});

		DB::commit();

		return redirect()->route('users.account.show',[$uid])->with("credit_tab",true);
	}

	public function createAppro()
	{
		return view("transactions.lists.appro")->with("creditables",User::all());
	}

	public function storeAppro(Request $request,TransactionFactory $factory)
	{
		$this->validate($request, [
			'credited' => 'required|array',
		]);

		DB::transaction(function() use($request,$factory){
			foreach ($request->get("credited") as $uid) {
				$factory->buildAppro($request->get("wording"),$request->get("amount"),$uid);
			}
		});

		return redirect()->route('users.accounts')->withErrors(["ok"=>count($request->get("credited"))." Utilisateurs Crédités"]);
	}

	public function acquitAll(Request $request, $group, TransactionFactory $factory)
	{
		$uid = $group->first()->credited_user_id;

		DB::transaction(function() use($group){
			$group->each(function($t) {
				$t->state = "acquited";
				$t->update();
			});
		});

		return redirect()->back()->with("credit_tab",true);
	}
}
