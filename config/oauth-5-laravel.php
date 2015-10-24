<?php

return [

	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => 'Session',

	/**
	 * Consumers
	 */
	'consumers' => [

		'Google' => [
			'client_id'	 => env('OAUTH_ID'),
			'client_secret' => env('OAUTH_SECRET'),
			'scope'		 => ['userinfo_email', 'userinfo_profile'],
		],


		'Facebook' => [
			'client_id'	 => '',
			'client_secret' => '',
			'scope'		 => [],
		],

	]

];