<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Post;
use Auth;

class PostController extends Controller
{

	protected $actions = ["store","update","destroy"];

	public function canStore()
	{
		return true;
	}

	public function executeStore(Request $request)
	{
		$inputs = $request->only(['category', 'body']);

		Post::create(array_merge($inputs, ['user_id' => Auth::user()->id]));

		return back();
	}

	public function edit($post)
	{
		$data['post'] = $post;
		return view('posts.edit', $data);
	}

	public function canUpdate(Post $post)
	{
		return Auth::user()->isAllowed(null, $post->user->id);
	}

	public function executeUpdate(Request $request, Post $post)
	{
		$inputs = $request->only(['body']);

		$post->update($inputs);

		return $post->showBody();
	}

	public function canDestroy(Post $post)
	{
		return Auth::user()->isAllowed("destroy_post", $post->user->id);
	}

	public function executeDestroy(Post $post)
	{
		$post->delete();

		return '<div style="text-align: center; color: #777; font-size: smaller;">Supprimé</div>';
	}
}
