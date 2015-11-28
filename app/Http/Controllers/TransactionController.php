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

class TransactionController extends Controller
{

	protected $actions = ["destroy","update","store","storeOutgo","storeAppro"];
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
		$data = ["user" => Auth::user()];
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

	public function canStore()
	{
		return true;
	}

	public function store(Request $request,TransactionFactory $factory)
	{
		$factory->build($request->all());

		return redirect()->route('users.account.show',Auth::user()->id)->with("credit_tab",true);
	}

	public function canUpdate(Transaction $t)
	{
		return Auth::user()->isAllowed("update_buquage", $t->credited_user_id);
	}

	public function executeUpdate(Request $request, $t)
	//utilisé pour la validation d'un buquage
	{
		$t->state = "acquited";
		$t->update();

		return redirect()->back();
	}

	
	public function canDestroy(Transaction $t)
	{
		if($t->credited_user_id==User::getBankAccount()->id){
		//si c'est une dépense (au sens où on déclare avoir utilisé l'argent de la proms)
			return Auth::user()->isAllowed("outgo",$t->debited_user_id);
		}
		return Auth::user()->isAllowed("destroy_buquage", $t->credited_user_id);
	}

	public function executeDestroy(Request $request,Transaction $t)
	{
		$uid = $t->credited_user_id;
		$t->delete();

		if($t->credited_user_id == User::getBankAccount()->id){
			return redirect()->back();
		}

		return redirect()->back()->with("credit_tab",true);
	}

	public function createAppro($user)
	//paramètre $user présent pour pouvoir buquer quelqu'un d'autre que soi
	{
		return view("transactions.appro")->with("user",$user);
	}

	public function canStoreAppro($user)
	{
		return Auth::user()->isAllowed("appro");
	}

	public function executeStoreAppro(Request $request,TransactionFactory $factory,$user)
	{
		$factory->buildAppro($request->get("wording"),$request->get("amount"),$user->id);

		return redirect()->route('users.account.show',[$user->id])->with("credit_tab",true);
	}

	public function createOutgo()
	{
		return view("transactions.outgo");
	}

	public function canStoreOutgo()
	{
		return Auth::user()->isAllowed("create_outgo");
	}

	public function ExecuteStoreOutgo(Request $request,TransactionFactory $factory)
	{
		$user = Auth::user();
		$factory->build([
			"wording"	=> $request->get("wording"),
			"amount"	=> $request->get("amount"),
			"credited_user_id"	=> User::getBankAccount()->id,
			"debited_user_id"	=> $user->id,
			"state"		=> "acquited",
			]);
		
		return redirect()->route('users.account.show',[$user->id]);
	}
}
