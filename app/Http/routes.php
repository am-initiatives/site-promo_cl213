<?php


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/




// Routes d'authentification
Route::group(['prefix' => 'auth'], function () {
	Route::get('login', ['as' => 'auth.login', 'uses' => 'Auth\AuthController@getLogin']);
	Route::post('login', ['as' => 'auth.signin', 'uses' => 'Auth\AuthController@postLogin']);
	Route::get('google', ['as' => 'auth.google', 'uses' => 'Auth\AuthController@getLoginWithGoogle']);
	Route::get('logout', ['as' => 'auth.logout', 'uses' => 'Auth\AuthController@getLogout']);
});

// Configuration
Route::group(['prefix' => 'config', 'middleware' => 'auth'], function () {
	Route::get('first', ['as'=>'configs.first', 'uses' => 'ConfigController@first']);
	Route::post('first/password', ['as'=>'configs.first.password', 'uses' => 'ConfigController@postFirstPassword']);
	Route::post('first/location', ['as'=>'configs.first.location', 'uses' => 'ConfigController@postFirstLocation']);
});

// Routes authentifiées et activés
Route::group(['middleware' => ['auth', 'active']], function()
{
	Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);

	// User
	Route::get('users', ['as' => 'users.index', 'uses' => 'UserController@index']);
	Route::get('users/{user}', ['as' => 'users.show', 'uses' => 'UserController@show']);
	Route::get('users/{user}/parameters', ['as'=>'users.parameters', function () {
		return view('users.parameters');
	}]);

	// Posts
	Route::resource('posts', 'PostController',
				['except' => ['index','create','show']]);

	// Liste promss

	// Buqueur
	Route::get('users/accounts', ['as' => 'users.accounts', 'uses' => 'UserController@accounts']);
	Route::get('users/{user}/account', ['as' => 'users.account.show', 'uses' => 'UserController@account']);
	Route::get('users/{user}/account/details', ['as' => 'users.account.details', 'uses' => 'UserController@accountDetails']);

	Route::resource('transactions', 'TransactionController',
				['except' => ['edit','show']]);

	Route::get('users/{user}/appro/create',['as' => 'transactions.appro.create', 'uses' => "TransactionController@createAppro"]);
	Route::post('users/{user}/appro/store',['as' => 'transactions.appro.store', 'uses' => "TransactionController@storeAppro"]);

	Route::resource('transactionlist', 'TransactionListController',
				['except' => ['index','show']]);

	// Map plein écran
	Route::get('tools/map', ['as'=>'tools.map', 'uses' => 'ToolController@map']);
	Route::get('tools/map/full', ['as'=>'tools.map.full', 'uses' => 'ToolController@mapFull']);
	Route::get('tools/map/location', ['as'=>'tools.map.location', 'uses' => 'ToolController@mapUpdate']);
	Route::post('tools/map/location', ['as'=>'tools.map.store-location', 'uses' => 'ToolController@storeLocation']);

	// Login en tant que
	Route::get('auth/as/{id}', ['as' => 'auth.log_as', 'uses' => function ($id) {
		if(auth()->user()->isAllowed()) {
			auth()->loginUsingId($id);
			return redirect()->route('home');
		}
	}]);
});

/*================================
=            Bindings            =
================================*/

Route::bind('user',Binders::get("user"));
Route::bind('transactions',Binders::get("transaction"));
Route::bind('transactionlist',Binders::get("transactionList"));
Route::bind('posts',Binders::get("post"));

/*=====  End of Bindings  ======*/



// Route::get('pass', function () {
// 	dd(Hash::make('HMlar\'sssT154'));
// });
