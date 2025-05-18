<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return Inertia('Posts/Index',[
            'posts' => PostResource::collection(Post::with('user')->paginate(7)),
        ]); 
    }

    public function show(Post $post)
    {   
        $post->load('user');
        return Inertia('Posts/Show',[
            'post' => PostResource::make($post),
            'comments' => CommentResource::collection(
                $post->comments()->paginate(7)
            )
        ]);
    }
}
