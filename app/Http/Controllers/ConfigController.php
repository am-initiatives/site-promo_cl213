<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use App\Models\User;
use Carbon\Carbon;

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
		if ($user = Auth::user()) {
			if ($user->setPassword($request)) {
				return "OK";
			} else {
				return "Validation error";
			}
		} else {
			return 'No user';
		}
	}

	/**
	 * Configure password for the first time.
	 *
	 * @return Response
	 */
	public function postFirstLocation(Request $request)
	{
		$location = json_decode($request->input('location'), true);
		
		$pos = array_map('floatval', $location);

		if (Auth::user()->update(['pos'=>json_encode($pos)]))
			return 'OK';
		else
			return 'Validation error';
	}
}
