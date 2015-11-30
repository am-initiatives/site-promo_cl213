<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\User;
use Auth;

class MapController extends Controller
{
	protected $actions = ["storeLocation"];
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function show()
	{
		$locations = json_encode(User::getPositions());

		return view('map.show', ['locations' => $locations]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function full()
	{
		$locations = json_encode(User::getPositions());

		return view('map.full', ['locations' => $locations]);
	}

	public function canStoreLocation()
	{
		return true;
	}

	public function executeStoreLocation(Request $request)
	{
		$location = $request->input('location');

		$pos = [(float) round($location[0], 7), (float) round($location[1], 7)];

		$user = Auth::user();
		$user->pos = json_encode($pos);

		if ($user->update())
			return 'Enregistré';
		else
			return 'Une erreur est survenue';
	}
}
