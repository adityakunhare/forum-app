<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return Inertia('Posts/Index', [
            'posts' => PostResource::collection(
                Post::with('user')->latest()->latest('id')->paginate(7)
            ),
        ]);
    }

    public function show(Post $post)
    {
        $post->load('user');
        
        return Inertia('Posts/Show', [
            'post' => fn () => PostResource::make($post),
            'comments' => fn () => CommentResource::collection(
                $post->comments()->latest()->latest('id')->paginate(7)
            )
        ]);
    }

    public function create(Request $request)
    {
        return Inertia('Posts/Create'); 
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required','min:5','max:255', 'string'],
            'body' => ['required','string', 'min:100','max:2500']
        ]); 

        $data['user_id'] = $request->user()?->id;
        $post = Post::create($data);

        return redirect(route('posts.show',$post->id));
    }
}
