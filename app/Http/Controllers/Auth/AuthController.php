<?php

namespace App\Http\Controllers\Auth;

use Auth;

use Log;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

// Because we then use OData
use Illuminate\Http\Request;
use App\Http\Requests;

use App\Services\Impersonator;

use Collective\Html\HtmlFacade as Html;

class AuthController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers {
		getLogout as parentGetLogout;
	}
	use ThrottlesLogins;

	protected $redirectPath = '/';
	protected $loginPath = 'auth/login';
	protected $username = 'email';



	/**
	 * Create a new authentication controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest', ['except' => 'getLogout']);
	}

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(array $data)
	{
		return Validator::make($data, [
			'name' => 'required|max:255',
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required|confirmed|min:6',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	protected function create(array $data)
	{
		return User::create([
			'name' => $data['name'],
			'email' => $data['email'],
			'password' => bcrypt($data['password']),
		]);
	}




	/**
	 * Login user using Google
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function getLoginWithGoogle(Request $request)
	{
		// get data from request
		$code = $request->get('code');

		// get google service
		$googleService = \OAuth::consumer('Google');

		// check if code is valid

		// if code is provided get user data and sign in
		if ( ! is_null($code))
		{
			// This was a callback request from google, get the token
			// (This is a request from the server to google ! The server needs internet access)
			$token = $googleService->requestAccessToken($code);
			// Send a request with it
			$result = json_decode($googleService->request('https://www.googleapis.com/oauth2/v1/userinfo'), true);



			$user = User::where('google_id', $result['id'])->first();
			// Si l'utilisateur a une adresse Gadz.org, on vérifie si son adresse est connue
			if (!$user) {
				if (isset($result['hd']) and in_array($result['hd'],['gadz.org','m4am.net'])){
					$user = User::where('email', $result['email'])->first();

					if($user) {
						// On ajoute l'id pour les futures connexions
						$user->forceFill(['google_id' => $result['id'], 'active' => 1])->save();
					} else {
						Log::info('Connexion via Google refusée : '.$result['name'].' | '.$result['id'].' (Utilisateur inconnu');
						return response('Utilisateur inconnu.<br/>'.Html::linkroute('auth.login', 'Revenir'));
					}
				} else {
					Log::info('Connexion via Google refusée : '.$result['name'].' | '.$result['id'].' (L\'adresse n\'est pas une adresse Gadz.org)');
					return response('Le compte Google doit être lié à une adresse Gadz.org connue.<br/>'.Html::linkroute('auth.login', 'Revenir').'<br/>Si tu es connecté seulement avec un compte Google standard, connecte-toi d\'abord sur : '.Html::link('http://mail.gadz.org'));
				}
			}

			//mise à jour de l'image
			$user->google_pic = $result["picture"];
			$user->update();

			Auth::login($user);

			return redirect()->intended('/');
		} else { // if not ask for permission first
			// get googleService authorization
			$url = $googleService->getAuthorizationUri();

			// return to google login url
			return redirect((string)$url);
		}
	}

	public function getLogout(Impersonator $imp)
	{
		$user = Auth::user();
		if($user && $imp->isImpersonating()){
			$imp->removeImpersonation();
			return redirect()->route('home');
		}
		else
		{
			return $this->parentGetLogout();
		}
	}
}
