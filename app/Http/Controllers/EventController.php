<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Event;

use Auth;
use Validator;
use DB;

class EventController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view("events.index")
			->with("events",Event::all())
			->with("user",Auth::user());
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view("events.create")
			->with("user",Auth::user());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$validator = Validator::make($request->all(),[
			"name" 	=> "required|string",
			"description"			=> "required|string|between:5,1090"
			]);

		if($validator->fails()){
			return redirect()->route('event.create')
						->withErrors($validator)
						->withInput();
		}

		$data = $request->all();
		$data["picture"] = url('images/default_picture.png');

		DB::beginTransaction();

		if(!($event = Event::create($data))){
			DB::rollback();
			return redirect()->route('event.create')
						->withErrors(["save"=>"Event save error"])
						->withInput();
		}

		//on authorise l'utilisateur
		$user = Auth::user();
		if(!$user->hasPermission("admin")){
			foreach (["edit","update","destroy"] as $action) {
				if(!$user->addPermission($action."_event_".$event->id)){
					DB::rollback();
					return redirect()->route('event.create')
								->withErrors(["save"=>"User permission update error"])
								->withInput();
				}
			}
		}

		//manque création du compte associé

		DB::commit();

		return redirect()->route('event.show',$event);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		return view("events.show")
			->with("event",$id)
			->with("user",Auth::user());
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}
}
