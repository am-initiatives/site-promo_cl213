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

// Mot de passe oublié
Route::group(['prefix' => 'password'], function () {
	Route::get('email', ['as' => 'password.email', 'uses' => 'Auth\PasswordController@getEmail']);
	Route::post('email', ['as' => 'password.email.store', 'uses' => 'Auth\PasswordController@postEmail']);
	Route::get('reset/{token}', ['as' => 'password.reset', 'uses' => 'Auth\PasswordController@getReset']);
	Route::post('reset', ['as' => 'password.reset.store', 'uses' => 'Auth\PasswordController@postReset']);
});

// Configuration
Route::group(['prefix' => 'config', 'middleware' => 'auth'], function () {
	Route::get('first', ['as'=>'configs.first', 'uses' => 'ConfigController@first']);
	Route::post('first/password', ['as'=>'configs.first.password', 'uses' => 'ConfigController@postFirstPassword']);
	Route::post('first/location', ['as'=>'configs.first.location', 'uses' => 'ConfigController@postFirstLocation']);
});

Route::get('/changelog', ['as' => 'changelog', 'uses' => 'HomeController@changelog']);

// Routes authentifiées et activés
Route::group(['middleware' => ['auth', 'active']], function()
{
	Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);

	// User
	Route::get('users', ['as' => 'users.index', 'uses' => 'UserController@index']);
	Route::get('users/{user}', ['as' => 'users.show', 'uses' => 'UserController@show']);

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

	//dépenses
	Route::get('users/outgo/create',['as' => 'transactions.outgo.create', 'uses' => "TransactionController@createOutgo"]);
	Route::post('users/outgo/store',['as' => 'transactions.outgo.store', 'uses' => "TransactionController@storeOutgo"]);

	//appros
	Route::get('users/{user}/appro/create',['as' => 'transactions.appro.create', 'uses' => "TransactionController@createAppro"]);
	Route::post('users/{user}/appro/store',['as' => 'transactions.appro.store', 'uses' => "TransactionController@storeAppro"]);
	Route::get('transactionlists/appro/create',['as' => 'transactionlists.appro.create', 'uses' => "TransactionListController@createAppro"]);
	Route::post('transactionlists/appro/store',['as' => 'transactionlists.appro.store', 'uses' => "TransactionListController@storeAppro"]);
	Route::put('transactionlists/acquit-all/{transactionlists}', ['as' => 'transactionlists.acquit_all', 'uses' => "TransactionListController@acquitAll"]);

	Route::resource('transactionlists', 'TransactionListController',
				['except' => ['index','create']]);


	Route::resource('event', 'EventController');
	Route::get("event/manage/{event}",["as"=>"event.manage","uses"=>"EventController@manage"]);

	// Map plein écran
	Route::get('map', ['as'=>'map.show', 'uses' => 'MapController@show']);
	Route::get('map/full', ['as'=>'map.full', 'uses' => 'MapController@full']);
	Route::post('map/location', ['as'=>'map.store-location', 'uses' => 'MapController@storeLocation']);

	// Login en tant que
	Route::get('auth/as/{user}', ['as' => 'auth.log_as', 'uses' => 'Auth\AuthController@logAs']);

	/*========================================
	=            Gestion de la DB            =
	========================================*/

	//seed de la db
	Route::get('artisan/seed/{seeder}',['as'=>"artisan.seed","uses"=>'ArtisanController@seed']);

	//migration de la db
	Route::get('artisan/migrate',['as'=>"artisan.migrate","uses"=>'ArtisanController@migrate']);
});

/*======================================
=            Model Bindings            =
======================================*/

Route::bind('user',function($id){
	return App\Models\User::findOrFail($id);
});

Route::bind('transactions',function($id){
	return App\Models\Transaction::findOrFail($id);
});

Route::bind('transactionlists',function($id){
	$group = App\Models\Transaction::where("group_id",$id)->get();

	if($group->count()==0){
		abort(404);
	}

	return $group;
});

Route::bind('posts',function($id){
	return App\Models\Post::findOrFail($id);
});

Route::bind('event',function($id){
	return App\Models\Event::findOrFail($id);
});

/*=====  End of Model Bindings  ======*/



Route::get('pass/{pass}', ['as' => 'pass', 'uses' => function ($pass) {
	echo Hash::make($pass);
}]);
