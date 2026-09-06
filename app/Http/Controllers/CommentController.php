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
        $data = $request->validate([
            "body" => ["required", "string", "max:2500"],
        ]);
        $data['user_id'] = $request->user()->id;
        $data['post_id'] = $post->id;

        Comment::create($data);
        return redirect(
            $post->showRoute($request->query())
        )->banner("Comment added.");
    }

    public function destroy(Request $request, Comment $comment)
    {
        Gate::authorize("delete", $comment);
        $comment->delete();
        return redirect(
            $comment->post->showRoute(['page' => $request->query('page')])
        )->banner('Comment deleted');
    }

    public function update(Request $request, Comment $comment)
    {
        Gate::authorize("update", $comment);
        $data = $request->validate([
            "body" => ["required", "string", "max:2500"],
        ]);
        $comment->update($data);
        return redirect(
            $comment->post->showRoute(["page" => $request->query("page")])
        )->banner("Comment updated.");
    }
}
