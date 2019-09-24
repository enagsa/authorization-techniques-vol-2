<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
	public function index(){
		$posts = Post::paginate();

		return view('admin.posts.index', compact('posts'));
	}

	public function store(Request $request){
		$this->authorize('create', Post::class);

		$request->user()->posts()->create([
			'title' => $request->title,
		]);

		return new Response('Post created', 201);
	}

	public function update(Post $post, UpdatePostRequest $request){
    	//$this->authorize('update', $post);

		$post->update([
			'title' => $request->title
		]);

		return 'Post updated!';
	}
}
