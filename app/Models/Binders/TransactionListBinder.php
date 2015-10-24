<?php

namespace App\Models\Binders;

use App\Services\Binder;

use App\Models\Transaction;


class TransactionListBinder extends BaseBinder
{
	
	public function resolve($gpeid,$action)
	{
		$group = Transaction::where("group_id",$gpeid);

		if($group->count()==0){
			abort(404);
		}

		return $group;
	}

	public function getParamsForAction($action,$group)
	{
		//tout le monde peut tout voir
		if($action=='show')
			return null;

		$t = clone $group;
		return [
			"name"		=> "buquage_list",
			"owner_id"	=> $t->first()->credited_user_id
			];
	}
}