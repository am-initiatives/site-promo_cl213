<?php

namespace App\Http\Controllers\Auth;

use Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

// Because we then use OData
use Illuminate\Http\Request;
use App\Http\Requests;

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

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $redirectPath = '/';
    protected $loginPath = 'auth/login';
    protected $username = 'username';



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
            $token = $googleService->requestAccessToken($code);
            // Send a request with it
            $result = json_decode($googleService->request('https://www.googleapis.com/oauth2/v1/userinfo'), true);

            // Verify if the domain is Gadz.org
            if (@$result['hd'] == 'gadz.org') {
                $user = User::where('google_id', $result['id'])->first();
                if ($user) {
                    Auth::login($user);
                    return redirect()->intended('/');
                }
                elseif ($user = User::where('email', $result['email'])->first()) {
                    // dd('coucou');
                    $user->forceFill(['google_id' => $result['id'], 'active' => 1])->save();
                    //dd($user);
                    Auth::login($user);
                    return redirect()->intended('/');
                }
                else {
                    return response('Utilisateur inconnu.<br/>'.Html::linkRoute('login', 'Revenir'));
                }
            }
            else {
                return response('L\'adresse doit être une adresse gadz.org valide.<br/>'.Html::linkRoute('login', 'Revenir'));
            }
        }
        // if not ask for permission first
        else
        {
            // get googleService authorization
            $url = $googleService->getAuthorizationUri();

            // return to google login url
            return redirect((string)$url);
        }
    }
}


// Your unique Google user id is: 118393875285241098193 and your name is Corentin Gitton

// array:9 [▼
//   "id" => "118393875285241098193"
//   "email" => "corentin.gitton@gadz.org"
//   "verified_email" => true
//   "name" => "Corentin Gitton"
//   "given_name" => "Corentin"
//   "family_name" => "Gitton"
//   "picture" => "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg"
//   "locale" => "fr"
//   "hd" => "gadz.org"
// ]
