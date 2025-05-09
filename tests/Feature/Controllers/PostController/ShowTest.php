<?php

namespace Tests\Feature\Controllers\PostController;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class ShowTest extends TestCase
{
	public function test_it_can_show_a_post()
	{
		$post = Post::factory()->create();

		$this->get(route('posts.show', $post))->assertComponent('Posts/Show');
	}

	public function test_it_passes_a_post_to_the_view()
	{
		$post = Post::factory()->create();
		
		$post->load('user');

		$this->get(route('posts.show', $post))
			->assertHasResource('post',PostResource::make($post));
	}
}
