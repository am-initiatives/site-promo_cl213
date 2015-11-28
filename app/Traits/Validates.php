<?php

namespace App\Traits;

use Illuminate\Foundation\Validation\ValidatesRequests;

trait Validates {
	//valide les requêtes mais aussi les tableaux
	
	use ValidatesRequests {
		validate as validateRequest;
	}

	public function validate($request, array $rules, array $messages = [], array $customAttributes = [])
	//surcharge du trait pour permettre de valider un tableau plutôt qu'une requête
	{
		if(is_array($request)){
			$validator = $this->getValidationFactory()->make($request, $rules, $messages, $customAttributes);

			if ($validator->fails()) {
				$this->throwValidationException($request, $validator);
			}
		}
		else
		{
			$this->validateRequest($request,$rules,$messages,$customAttributes);
		}
	}
}