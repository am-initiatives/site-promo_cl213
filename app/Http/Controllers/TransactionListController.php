<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Validator;

use App\Models\User as User;
use App\Models\Transaction as Transaction;

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

		return view('transactionlist.create', $data);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
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
					'wording'		   => $request->get('wording'),
					'amount'			=> (integer) 100*$request->get('amount'),
					'credited_user_id'  => Auth::user()->id,
					'debited_user_id'   => $debited,
					'group_id'		  => $uuid,
					'state'			 => "pending"
					);

				Transaction::create($data);
			}
		});

		return redirect()->route('transactions.show',[Auth::user()]);
	}

	public function show($id) {}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	//vue pour ajouter une personne après coup
	{
		$uid = null;
		$group = Transaction::where("group_id",$id)->get();
		if($group->count()>0){
			$t = $group[0];
			$uid = $t->credited_user_id;
			if(Auth::user()->isAllowed("edit_buquage",$t->credited_user_id)){
				$debitables = Auth::user()->availableAccounts();

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

				return view("transactions.lists.edit",$data);
			}
		}
		return redirect()->route("transactions.index");
	}

	public function update(Request $request, $id)
	//ajouter une personne après coup
	{
		$validator = Validator::make($request->all()+["id"=>$id], [
			'debited' => 'required|array',
			'id' => 'required|exists:transactions,group_id'
		]);

		if ($validator->fails()) {
			return redirect()->route('transactionlist.edit',$id)
						->withErrors($validator)
						->withInput();
		}

		$t = Transaction::where("group_id",$id)->first();

		foreach ($request->get("debited") as $debited) {
			$data = array(
				'wording'		   => $t->wording,
				'amount'			=> $t->amount,
				'credited_user_id'  => $t->credited_user_id,
				'debited_user_id'   => $debited,
				'group_id'		  => $id,
				'state'			 => "pending"
				);

			Transaction::create($data);
		}

		return redirect()->route('accounts.show',[$t->credited_user_id])->with("credit_tab",true);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$uid = null;
		$group = Transaction::where("group_id",$gpeid);
		if($group->count()>0){
			$t = Transaction::where("group_id",$gpeid)->first();
			$uid = $t->credited_user_id;
			if(Auth::user()->isAllowed("delete_buquage",$t->credited_user_id)){
				$group->delete();
			}
		}
		return redirect()->route('accounts.show',[$uid])->with("credit_tab",true);
	}
}
