<?php

return 	[
	"ressources" => [
		"transactions" => [
			'isRestricted'	=> function($action){
				return $action != "show" && $action != "index";
			},
			"getTarget" => function($item) {
				return [
					"action" => "buquage",
					"target" => !$item ? null : $item->credited_user_id
					];
			},
		],

		"transactionlist" => [
			"isRestricted"	=> function($action){
				return $action != "show" && $action != "index";
			},
			"getTarget" => function($item) {
				return [
					"action" => "buquage_list",
					"target" => !$item ? null : $item->first()->credited_user_id
					];
			},
		],
		
		"posts" => [
			"isRestricted"	=> function($action){
				return true;
			},
			"getTarget" => function($post) {
				switch ($action) {
					case 'edit':
					case 'update':
						return [
							"action" => null,//même les admins ont pas le droit
							"target" => !$item ? null : $post->user->id
							];
						break;
					case 'store':
					case 'destroy':
						return [
							"action" => "post",
							"target" => !$item ? null : $post->user->id
							];
						break;
				}
			},
		],
		"user" => [
			"isRestricted"	=> function($action){
				return false;
			},
			"getTarget" => function($post) {},
		],
	],


	"basic" => [
		"home"						=> true,
		"auth.login"				=> true,
		"auth.signin"				=> true,
		"auth.google"				=> true,
		"auth.logout"				=> true,
		"configs.first"				=> true,
		"configs.first.password"	=> true,
		"configs.first.location"	=> true,
		"users.index"				=> true,
		"users.show"				=> true,
		"users.accounts"			=> true,
		"users.account.show"		=> true,
		"users.account.details"		=> true,
		"tools.map.full"			=> true,
		"tools.map"					=> true,
		"tools.map.location"		=> [
			"name"		=> "update_location",
			"getTarget" => function($route){
				return Auth::user()->id;
			}
		],
		"tools.map.store-location"		=> [
			"name"		=> "update_location",
			"getTarget" => function($route){
				return Auth::user()->id;
			}
		],
		"transactions.appro.create" => [
			"name"		=> "create_appro",
			"param"		=> "user",
			'getTarget'	=> function($user){
				return $user->id;
			}
		],
		"transactions.appro.store" => [
			"name"		=> "store_appro",
			"param"		=> "user",
			"getTarget"	=> function($user){
				return $user->id;
			}
		],
		"auth.log_as" => [
			"name"		=> "log_as",
			"param"		=> "user",
			"getTarget"	=> function($user){
				return $user->id;
			}
		],
	]
];