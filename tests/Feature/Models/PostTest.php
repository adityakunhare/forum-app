<?php

namespace Tests\Feature\Models;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_uses_title_case_for_titles()
    {
        $post = Post::factory()->create([
            'title' => 'Hello, how are you?'
        ]);
        $this->assertEquals($post->title, 'Hello, How Are You?');
    }

    public function test_it_generates_the_html()
    {
        $post = Post::factory()->make(['body' => '## Hello world']);
        $post->save();
        $this->assertEquals($post->html, str($post->body)->markdown());
    }
}
