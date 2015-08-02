<?php

/*
|--------------------------------------------------------------------------
| Temporary stuff
|--------------------------------------------------------------------------
*/

setlocale(LC_TIME, 'French');


Html::macro('solde', function($value, $unit = NULL)
{
    $solde[] = number_format($value, 2);
    if (isset($unit)) {
        $solde[] = $unit;
    }

    $color = $value < 0 ? '#A00' : '#08A';

    return '<strong style="color: '.$color.'">'.join(" ", $solde).'</strong>';
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



// Authentication routes...
Route::group(['prefix' => 'auth'], function () {
    Route::get('login', ['as' => 'login', 'uses' => 'Auth\AuthController@getLogin']);
    Route::post('login', 'Auth\AuthController@postLogin');
    Route::get('google', ['as' => 'loginwithgoogle', 'uses' => 'Auth\AuthController@getLoginWithGoogle']);
    Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@getLogout']);
});


Route::group(['middleware' => ['auth', 'active']], function()
{
    // Route::get('/', ['as' => 'home', function () {return view('welcome');}]);
    Route::get('/', ['as' => 'loginwithgoogle', 'uses' => 'HomeController@index']);

    // Profil

    // Liste promss

    // Buqueur
    Route::get('accounts/{id}', ['as' => 'accounts.show', 'uses' => 'AccountController@show']);

    Route::get('transfers', ['as' => 'transfers.index', 'uses' => 'TransferController@index']);
    Route::get('transfers/create', ['as' => 'transfers.create', 'uses' => 'TransferController@create']);
    Route::post('transfers', ['as' => 'transfers.store', 'uses' => 'TransferController@store']);
});






Route::get('test', function () {
    // $pass = Hash::make('password');
    // dd($pass);

    // $accounts = App\Account::all();

    // dd($accounts[1]->recap());

    return Html::linkRoute('login', 'Revenir');
});