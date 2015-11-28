<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

use App\Models\Event;
use App\Models\Permission;
use App\Models\User;
use App\Models\UserWithHidden;

use App\Services\Impersonator;

use Auth;
use DB;

class EventController extends Controller
{

	protected $actions = ["edit","store","update","destroy"];
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

	public function canStore()
	{
		return Auth::user()->isAllowed("store_event");
	}

	public function executeStore(Request $request)
	{
		$this->validate($request,[
			"name" 	=> "required|string",
			"description"			=> "required|string|between:5,1090"
			]);

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
		$admin = "admin_event_".$event->id;
		$user = Auth::user();
		if(!$user->hasPermission("all")){
				if(!$user->addRole($admin)){
					return $this->redirectCreate("User permission update error");
				}
		}

		//on initialise les permissions
		foreach ([
				["destroy",$admin],
				["edit",$admin],
				["update",$admin],
				["edit","edit_event_".$event->id]
			] as $row) {

			$role = $row[1];
			$action = $row[0];
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

	public function canEdit(Event $event)
	{
		return Auth::user()->isAllowed("edit_event",$event->id);
	}

	public function executeEdit(Event $event,Impersonator $imp)
	{
		$imp->impersonate($event);

		return view("events.edit");
	}

	public function manage(Event $event)
	//utilisé pour ajouter ou retirer des harpags ou admin de l'event
	{
		return view("events.manage")
			->withUser(Auth::user())
			->withEvent($event)
			->withPgs(User::all());
	}


	public function canUpdate(Event $event)
	{
		return Auth::user()->isAllowed("update_event",$event->id);
	}

	public function executeUpdate(Request $request,Event $event)
	//utilisé pour ajouter ou retirer des harpags ou admin de l'event
	{
		$this->validate($request,["role"=>"required|array"]);

		DB::transaction(function() use ($request,$event){
			foreach ($request->get("role") as $uid => $role) {
				$this->validate(["uid"=>$uid,"role"=>$role],[
					"uid"	=> "required|exists:users,id",
					"role"	=> "required|in:admin,harpags,none"]);

				$user = User::findOrFail($uid);

				if($user->hasPermission("all")) continue;

				$user->removeRole("admin_event_".$event->id);
				$user->removeRole("edit_event_".$event->id);

				switch ($role) {
					case 'admin':
						$user->addRole("admin_event_".$event->id);
						break;
					case 'harpags':
						$user->addRole("edit_event_".$event->id);
						break;
				}
			}

		});

		return redirect()->back()->withErrors(collect(["Droits mis à jour"]));
	}

	public function canDestroy(Event $event)
	{
		return Auth::user()->isAllowed("destroy_event",$event->id);
	}
	
	public function executeDestroy(Event $event)
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
			Permission::where("permission",'like',"%_event_".$event->id)->delete();

			UserWithHidden::where("roles","like",'%_event_'.$event->id.'%')->get()->each(function($usr) use($event){
				$roles = [];
				$deleted = false;
				foreach ($usr->getRoles() as $role) {
					if(!preg_match('/[a-zA-Z]+_event_'.$event->id."/", $role)){
						$roles[] = $role;
					}
					else
					{
						$deleted=true;
					}
				}
				if($deleted){
					$usr->roles = json_encode($roles,true);
					$usr->update();
				}
			});

			$event->delete();
		});

		return redirect()->route("event.index")
				->withErrors(collect(["Événement supprimé"]));
	}
}
