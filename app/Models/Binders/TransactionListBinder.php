<?php

namespace App\Models\Binders;

use App\Services\Binder;

use App\Models\Transaction;


class TransactionListBinder extends BaseBinder
{
	
	public function resolve($gpeid,$route)
	{
		$group = Transaction::where("group_id",$gpeid);

		if($group->count()==0){
			abort(404);
		}

		return $group;
	}

	public function getParamsForAction($action,$group)
	{
		switch ($action) { //chemin extrait
			case 'edit':
				$t = clone $group;
				$owner_id = $t->first()->credited_user_id;
				break;
			case 'destroy':
				$t = clone $group;
				$owner_id = $t->first()->credited_user_id;
				break;
			default:
				return null;
		}

		return [
			"name"		=> "buquage_list",
			"owner_id"	=> $owner_id
			];
	}
}