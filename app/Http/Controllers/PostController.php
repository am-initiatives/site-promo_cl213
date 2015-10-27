<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Post;
use Auth;

class PostController extends Controller
{

	public function store(Request $request)
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


	public function update(Request $request, $post)
	{
		$inputs = $request->only(['body']);

		$post->update($inputs);

		return $post->showBody();
	}

	public function destroy($post)
	{
		$post->delete();

		return '<div style="text-align: center; color: #777; font-size: smaller;">Supprimé</div>';
	}
}
