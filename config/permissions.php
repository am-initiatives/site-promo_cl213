<?php

return 	[
	"ressources" => [
		"transactions" => [
			'isRestricted'	=> function($action){
				return !in_array($action,["show","create","index","store"]) ;
			},
			"getTarget" => function($item,$action) {
				if($action=="destroy" && $item->credited_user_id==App\Models\User::getBankAccount()->id){
				//si c'est une dépense (au sens où on déclare avoir utilisé l'argent de la proms)
					return [
						"action" => "outgo",
						"target" => $item->debited_user_id,
					];
				}
				return [
					"action" => "buquage",
					"target" => !$item ? null : $item->credited_user_id
					];
			},
		],

		"transactionlist" => [
			"isRestricted"	=> function($action){
				return !in_array($action,["show","create","index","store"]) ;
			},
			"getTarget" => function($item,$action) {
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
			"getTarget" => function($post,$action) {
				switch ($action) {
					case 'edit':
					case 'update':
						return [
							"action" => null,//même les admins ont pas le droit
							"target" => !$post ? null : $post->user->id
							];
						break;
					case 'store':
					case 'destroy':
						return [
							"action" => "post",
							"target" => !$post ? null : $post->user->id
							];
						break;
				}
			},
		],

		"user" => [
			"isRestricted"	=> function($action){
				return false;
			},
			"getTarget" => function($post,$action) {},
		],

		"event" => [
			"isRestricted"	=> function($action){
				return $action != "show" && $action != "index";
			},
			"getTarget" => function($event,$action) {
				return [
					"action" => "event".(!$event ? "" : "_".$event->id),
					"target" => null,
				];
			},
		],
	],


	"basic" => [
		"pass"						=> true,
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
		"artisan.seed"		=> [
			"name"		=> "seed_database",
			"getTarget" => function($route){
				return App\Models\User::where("email","adrien.debord@gadz.org")->first()->id;
			}
		],
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
				return null;
			}
		],
		"transactions.appro.store" => [
			"name"		=> "store_appro",
			"param"		=> "user",
			"getTarget"	=> function($user){
				return null;
			}
		],
		"transactions.outgo.create" => [
			"name"		=> "create_outgo",
			'getTarget'	=> function($user){
				return null;
			}
		],
		"transactions.outgo.store" => [
			"name"		=> "store_outgo",
			"getTarget"	=> function($user){
				return null;
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