<?php

namespace App\Models\Binders;

use App\Services\Binder;

use App\Models\Post;


class PostBinder extends BaseBinder
{
	
	public function resolve($id,$action)
	{
		return Post::findOrFail($id);
	}

	public function getParamsForAction($action,$post)
	{
		//tout le monde peut tout voir
		switch ($action) {
			case 'edit':
			case 'update':
				return [
					"name"		=> null,
					"owner_id"	=> $post->user->id
					];
				break;
			case 'destroy':
				return [
					"name"		=> "post",
					"owner_id"	=> $post->user->id
					];
				break;
			default:
				return null;
				break;
		}
	}
}