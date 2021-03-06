<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;


use Auth;
use App\Models\User;
use App\Models\Post;
use App\Models\Event;

class HomeController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$data['user'] = Auth::user();
		$data['positions'] = json_encode(User::getPositions());

		$data['posts'] = Post::where('category', 'general')->orderBy('created_at', 'desc')->get();
		$data["events"] = Event::orderBy("created_at","desc")->get();

		return view('home', $data);
	}

	public function changelog()
	{
		return view("changelog");
	}
}
