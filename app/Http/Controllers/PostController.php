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
            'post' => new PostResource(Post::first()),
            // 'posts' => PostResource::collection(Post::paginate(7)),
        ]); 
    }
}
