<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;


use Auth;
use App\User;
use App\Post;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data['user'] = Auth::user()->load('account');
        $data['positions'] = json_encode(User::getPositions());

        $data['posts'] = Post::where('category', 'general')->orderBy('created_at', 'desc')->get();

        return view('home', $data);
    }
}
