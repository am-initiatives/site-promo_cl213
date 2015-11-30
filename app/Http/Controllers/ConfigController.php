<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use App\Models\User;
use Carbon\Carbon;

use Hash;

class ConfigController extends Controller
{
	/**
	 * Configure at first connection.
	 *
	 * @return Response
	 */
	public function first()
	{
		if (! $user = Auth::user()) {
			redirect()->route('auth.login');
		}

		$data['locations'] = json_encode(User::getPositions());

		return view('configs.first', $data);
	}

	/**
	 * Configure password for the first time.
	 *
	 * @return Response
	 */
	public function postFirstPassword(Request $request)
	{
		$this->validate($request,["password"=>"confirmed"]);

		$password = $request->input('password');

		$user = Auth::user();

		$user->password = Hash::make($password);
		if($user->update()){
			return 'OK';
		}
		else
			return "Update error";
	}

	/**
	 * Configure password for the first time.
	 *
	 * @return Response
	 */
	public function postFirstLocation(Request $request)
	{
		$location = $request->input('location');
		
		$pos = array_map('floatval', $location);

		$user = Auth::user();

		$user->connected_at = Carbon::now();
		$user->pos = json_encode($pos);

		if ($user->update())
			return 'OK';
		else
			return 'Update error';
	}
}
