<?php

namespace App\Models\Binders;

use App\Services\Binder;

use App\Models\Transaction;


class TransactionBinder extends BaseBinder
{
	
	public function resolve($tid,$action)
	{
		return Transaction::findOrFail($tid);
	}

	public function getParamsForAction($action,$t)
	{
		//tout le monde peut tout voir
		if($action=='show')
			return null;
		return [
			"name"		=> "buquage",
			"owner_id"	=> $t->credited_user_id
			];
	}
}