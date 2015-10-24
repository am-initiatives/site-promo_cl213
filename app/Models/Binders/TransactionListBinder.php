<?php

namespace App\Models\Binders;

use App\Services\Binder;

use App\Models\Transaction;

class TransactionListBinder implements Binder
{
	
	public function resolve($gpeid,$route)
	{
		$group = Transaction::where("group_id",$gpeid);
		if($group->count()==0){
			abort(404);
		}
		return $group;
	}
}