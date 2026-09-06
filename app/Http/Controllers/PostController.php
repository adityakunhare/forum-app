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
use Laravel\Scout\Builder as ScoutBuilder;

class PostController extends Controller
{
    public function index(Request $request, Topic $topic = null)
    {
        if($request->query('query')){
            $posts = Post::search($request->query('query'))
                ->query(fn(Builder $query) => $query->with(['user','topic']))
                ->when($topic, fn(ScoutBuilder $query) => $query->where('topic_id', $topic->id));
        } else {
           $posts = Post::with(["user","topic"])
                    ->when($topic, fn(Builder $query) => $query->whereBelongsTo($topic))
                    ->latest()
                    ->latest("id"); 
        }

        return Inertia("Posts/Index", [
            "posts" => PostResource::collection($posts->paginate(7)->withQueryString()),
            "topics" => fn () => TopicResource::collection(Topic::all()),
            "selectedTopic" => fn() => $topic ? TopicResource::make($topic) : null,
            "query" => $request->query('query'),
        ]);
    }

    public function show(Request $request, Post $post)
    {
        if (!Str::endsWith($post->showRoute(), $request->path())) {
            return redirect($post->showRoute($request->query()), 301);
        }
        $post->load("user","topic");
        return Inertia("Posts/Show", [
            "post" => fn() => PostResource::make($post)->withLikePermission(),
            "comments" => fn() => CommentResource::collection(
                $post->comments()->latest()->latest("id")->paginate(7)
            ),
        ]);
    }

    public function create(Request $request)
    {
        return Inertia("Posts/Create", [
            'topics' => fn() => TopicResource::collection(Topic::all()),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "title" => ["required", "min:5", "max:255", "string"],
            "body" => ["required", "string", "min:100", "max:2500"],
            "topic_id" => ["required", "exists:topics,id"]
        ]);
        $data["user_id"] = $request->user()?->id;

        $post = Post::create($data);

        return redirect($post->showRoute($request->query()));
    }
}
