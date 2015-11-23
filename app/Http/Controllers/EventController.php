<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

use App\Models\Event;
use App\Models\Permission;

use App\Services\Impersonator;

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

		//on crée l'évent qui n'est en fait qu'un utilisateur caché
		$event = new Event();
		$event->email = preg_replace('/\s+/', '_', strtolower($data["name"]))."@cl213.fr";
		$event->phone = "";
		$event->first_name = $data["name"];
		$event->last_name = $data["name"];
		$event->nickname = $data["name"];
		$event->info = $data["description"];
		$event->roles = '["event"]';
		$event->hidden = 1;
		$event->active = 1;
		$event->connected_at = Carbon::now();

		if(!$event->save()){
			return $this->redirectCreate("Event save error");
		}

		//on authorise l'utilisateur
		$role = "admin_event_".$event->id;
		$user = Auth::user();
		if(!$user->hasPermission("all")){
				if(!$user->addRole($role)){
					return $this->redirectCreate("User permission update error");
				}
		}

		//on donne les droits au role
		foreach (["destroy","edit"] as $action) {
			if(!Permission::add($role,$action."_event_".$event->id)){
				return $this->redirectCreate("User permission update error");
			}
		}

		DB::commit();

		return redirect()->route('event.show',$event);
	}

	private function redirectCreate($msg)
	{
		DB::rollback();
		return redirect()->route('event.create')
					->withErrors(collect([$msg]))
					->withInput();
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
	public function edit($event,Impersonator $imp)
	{
		$imp->impersonate($event);

		return view("events.edit");
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
	public function destroy(Event $event)
	{
		if($event->debits->count()+$event->credits->count()!=0){
			return back()
				->withErrors(collect(["Des opérations ont déjà été effectuées pour cet événement, il est impossible de le supprimer"]));
		}

		if(!$event->hasRole("event")){
			return back()
				->withErrors(collect(["Impossible de supprimer un utilisateur"]));
		}

		DB::transaction(function() use ($event) {
			Permission::where("role","admin_event_".$event->id)->delete();
			$event->delete();
		});


		return redirect()->route("event.index")
				->withErrors(collect(["Événement supprimé"]));
	}
}
