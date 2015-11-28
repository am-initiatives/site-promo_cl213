<?php

namespace App\Services\Factories;

use Validator;
use Auth;

use Ramsey\Uuid\Uuid;

use App\Models\Transaction;
use App\Traits\Validates;

class TransactionFactory
{
	use Validates;

	public function build($params)
	{
		if(isset($params["force"]) && !Auth::user()->isAllowed("force_buquage")) unset($params["force"]);

		if(!isset($params["credited_user_id"])) $params["credited_user_id"] = Auth::user()->id;
		if(!isset($params["group_id"])) $params["group_id"] = Uuid::uuid4()->toString();
		if(!isset($params["state"])){
			if(isset($params["force"]) && $params["force"]){
				$params["state"] = "acquited";
			}
			else{
				$params["state"] = "pending";
			}
		}

		$this->validate($params, [
			'credited_user_id' => 'required|integer',
			'debited_user_id' => 'required|integer|not_in:'.$params["credited_user_id"],
			'wording' => 'required|between:5,255',
			'amount' => 'required|numeric|min:1',
		]);

		$params["amount"] = (integer) 100 * abs(floatval(str_replace(",", ".",$params['amount'])));

		Transaction::create($params);
	}

	public function buildAppro($wording,$amount,$uid)
	{
		return $this->build([
			"wording"	=> "Appro ".$wording,
			"amount"	=> $amount,
			"credited_user_id"	=> $uid,
			"debited_user_id"	=> \App\Models\User::getBankAccount()->id,
			"state"		=> "acquited",
			]);
	}
}