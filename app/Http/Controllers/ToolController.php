<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\User;
use Auth;

class ToolController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function map()
	{
		$locations = json_encode(User::getPositions());

		return view('tools.map', ['locations' => $locations]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function mapUpdate()
	{
		$locations = json_encode(User::getPositions());

		return view('tools.map-location', ['locations' => $locations]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function mapFull()
	{
		$locations = json_encode(User::getPositions());

		return view('tools.map-full', ['locations' => $locations]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function storeLocation(Request $request)
	{
		$location = json_decode($request->input('location'), true);
		
		$pos = array_map('floatval', $location);

		if (Auth::user()->update(['pos'=>json_encode($pos)]))
			return 'Enregistré';
		else
			return 'Une erreur est survenue';
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  Request  $request
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}
}
