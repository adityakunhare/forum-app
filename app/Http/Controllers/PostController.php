<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\TopicResource;
use App\Models\Post;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Topic $topic = null)
    {
        $posts = Post::with(["user","topic"])
                    ->when($topic, fn(Builder $query) => $query->whereBelongsTo($topic))
                    ->latest()
                    ->latest("id")
                    ->paginate(7);

        return Inertia("Posts/Index", [
            "posts" => PostResource::collection($posts),
            "topics" => fn () => TopicResource::collection(Topic::all()),
            "selectedTopic" => fn() => $topic ? TopicResource::make($topic) : null,
        ]);
    }

    public function show(Request $request, Post $post)
    {
        if (!Str::contains($post->showRoute(), $request->path())) {
            return redirect($post->showRoute($request->query()), 301);
        }
        $post->load("user");
        return Inertia("Posts/Show", [
            "post" => fn() => PostResource::make($post),
            "comments" => fn() => CommentResource::collection(
                $post->comments()->latest()->latest("id")->paginate(7)
            ),
        ]);
    }

    public function create(Request $request)
    {
        return Inertia("Posts/Create");
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "title" => ["required", "min:5", "max:255", "string"],
            "body" => ["required", "string", "min:100", "max:2500"],
        ]);

        $data["user_id"] = $request->user()?->id;
        $post = Post::create($data);

        return redirect($post->showRoute($request->query()));
    }
}
