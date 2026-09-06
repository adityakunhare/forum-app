<?php

namespace Tests\Feature\Models;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_it_generates_the_html()
    {
        $comment = Comment::factory()->make(['body' => '## Hello world']);
        $comment->save();

        $this->assertEquals($comment->html, str($comment->body)->markdown());
    }
}
