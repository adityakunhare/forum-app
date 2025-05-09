<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return Inertia('Posts/Index',[
            'posts' => PostResource::collection(Post::paginate(7)),
        ]); 
    }

    public function show(Post $post)
    {   
        $post->load('user');
        
        return Inertia('Posts/Show',[
            'post' => PostResource::make($post)
        ]);
    }
}
