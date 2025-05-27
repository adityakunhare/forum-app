<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        Comment::create([
            ...$request->validate([
                "body" => ["required", "string", "max:2500"],
            ]),
            "user_id" => $request->user()->id,
            "post_id" => $post->id,
        ]);

        return to_route("posts.show", $post)->banner("Comment added.");
    }

    public function destroy(Request $request, Comment $comment)
    {
        Gate::authorize("delete", $comment);

        $comment->delete();

        return to_route("posts.show", [
            "post" => $comment->post_id,
            "page" => $request->query("page"),
        ])->banner("Comment deleted.");
    }

    public function update(Request $request, Comment $comment)
    {
        Gate::authorize("update", $comment);
        $data = $request->validate([
            "body" => ["required", "string", "max:2500"],
        ]);
        $comment->update($data);

        return to_route("posts.show", [
            "post" => $comment->post_id,
            "page" => $request->query("page"),
        ])->banner("Comment updated.");
    }
}
