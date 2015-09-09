<?php

/*
|--------------------------------------------------------------------------
| Temporary stuff
|--------------------------------------------------------------------------
*/

Carbon\Carbon::setLocale('fr');


Html::macro('solde', function($value, $unit = NULL)
{
    $solde[] = number_format($value, 2);
    if (isset($unit)) {
        $solde[] = $unit;
    }

    $color = $value < 0 ? '#A00' : '#08A';

    return '<strong style="color: '.$color.'">'.join(" ", $solde).'</strong>';
});


Html::macro('diff', function($date)
{
    if ($date->diffInSeconds() <= 60) {
        $result = 'À l’instant';
    } elseif ($date->diffInDays() <= 7) {
        if ($date->isYesterday()) {
            $result = 'hier, à ' . $date->format('G:i');
        } else {
            $result = $date->diffForHumans(null, true);
        }
    } else {
        $result = $date->format('j M Y , g:ia');
    }

    return ucfirst($result);
});




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

// Routes authentifiées
Route::group(['middleware' => ['auth', 'active']], function()
{
    Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);

    // Profil
    Route::get('users', ['as' => 'users.index', 'uses' => 'UserController@index']);
    Route::get('users/{id}', ['as' => 'users.show', 'uses' => 'UserController@show']);

    // Posts
    Route::get('posts/edit/{id}', ['as' => 'posts.edit', 'uses' => 'PostController@edit']);
    Route::post('posts/edit/{id}', ['as' => 'posts.update', 'uses' => 'PostController@update']);
    Route::post('posts', ['as' => 'posts.store', 'uses' => 'PostController@store']);
    Route::delete('posts/{id}', ['as' => 'posts.destroy', 'uses' => 'PostController@destroy']);


    // Liste promss

    // Buqueur
    Route::get('accounts', ['as' => 'accounts.index', 'uses' => 'AccountController@index']);
    Route::get('accounts/{id}', ['as' => 'accounts.show', 'uses' => 'AccountController@show']);

    Route::get('transactions', ['as' => 'transactions.index', 'uses' => 'TransactionController@index']);
    Route::get('transactions/create', ['as' => 'transactions.create', 'uses' => 'TransactionController@create']);
    Route::post('transactions', ['as' => 'transactions.store', 'uses' => 'TransactionController@store']);

    Route::get('transactions/lists/create', ['as' => 'transactions.lists.create', 'uses' => 'TransactionController@createList']);
    Route::get('transactions/lists/tables', ['as' => 'transactions.lists.tables', 'uses' => 'TransactionController@listTables']);

    // Map plein écran
    Route::get('tools/map', ['as'=>'tools.map', function () {
        return view('tools.map');
    }]);
    Route::get('tools/map/full', ['as'=>'tools.map.full', function () {
        return view('tools.full-map');
    }]);
    Route::get('tools/map/location', ['as'=>'tools.map.location', function () {
        return view('tools.map-location');
    }]);
    Route::post('tools/map/location', ['as'=>'tools.map.store-location', 'uses' => 'ToolController@storeLocation']);

    // Login en tant que
    Route::get('auth/as/{id}', ['as' => 'auth.log_as', 'uses' => function ($id) {
        if(auth()->user()->isAllowed()) {
            auth()->loginUsingId($id);
            return redirect()->route('home');
        }
    }]);
});



Route::get('pass', function () {
    dd(Hash::make('HMlar\'sssT154'));
});



Route::get('test', function () {
    return view('tools.map');
});