<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Post;
use Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->isAllowed('post')) {
            $inputs = $request->only(['category', 'body']);

            Post::create(array_merge($inputs, ['user_id' => Auth::user()->id]));
        }

        return back();
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
        $data['post'] = Post::find($id);
        return view('posts.edit', $data);
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
        $post = Post::find($id);
        
        if (Auth::user()->isAllowed(null, $post->user_id)) {
            $inputs = $request->only(['body']);

            $post->update($inputs);

            return $post->showBody();
        } else {
            return $post->showBody();
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        if (Auth::user()->isAllowed('del_posts',$post->user_id)) {
            $post->delete();

            return '<div style="text-align: center; color: #777; font-size: smaller;">Supprimé</div>';
        } else {
            return false;
        }

    }
}
