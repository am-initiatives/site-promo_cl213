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
			'client_id'     => '1049838565225-0h95a0hab5onaln6e1k80tqa9k0bb6bt.apps.googleusercontent.com',
			'client_secret' => 'FYbo6dsLo5yKKYgdbjCuHeJO',
			'scope'         => ['userinfo_email', 'userinfo_profile'],
		],


		'Facebook' => [
			'client_id'     => '',
			'client_secret' => '',
			'scope'         => [],
		],

	]

];