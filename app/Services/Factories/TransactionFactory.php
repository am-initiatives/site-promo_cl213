<?php

namespace App\Services\Factories;

use Validator;
use Auth;

use Ramsey\Uuid\Uuid;

use App\Models\Transaction;

class TransactionFactory
{

	public function build($params)
	{
		if(!isset($params["credited_user_id"])) $params["credited_user_id"] = Auth::user()->id;
		if(!isset($params["group_id"])) $params["group_id"] = Uuid::uuid4()->toString();
		if(!isset($params["state"])) $params["state"] = "pending";

		$validator = Validator::make($params, [
			'credited_user_id' => 'required|integer',
			'debited_user_id' => 'required|integer|not_in:'.$params["credited_user_id"],
			'wording' => 'required|between:5,255',
			'amount' => 'required|min:1',
		]);

		if ($validator->fails()) {
			return $validator;
		}

		$params["amount"] = (integer) 100*$params['amount'];

		Transaction::create($params);
	}
}