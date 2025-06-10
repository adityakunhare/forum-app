<?php

namespace Tests\Feature\Controllers\PostController;

use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Models\Comment;
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

		$this->get($post->showRoute())->assertComponent('Posts/Show');
	}

	public function test_it_passes_a_post_to_the_view()
	{
		$post = Post::factory()->create();

		$post->load('user','topic');

		$this->get($post->showRoute())
			->assertHasResource('post', PostResource::make($post));
	}

	public function test_it_passes_comments_to_the_view()
	{
		$post = Post::factory()->create();
		$comments = Comment::factory(2)->for($post)->create();
		$comments->load('user');

		$this->get($post->showRoute())
			->assertHasPaginatedResource('comments', CommentResource::collection($comments->reverse()));
	}

	public function test_it_can_generate_a_route_to_the_show_page()
	{
		$post = Post::factory()->create();
		$this->assertEquals(
			$post->showRoute(), 
			route('posts.show',[$post, \Illuminate\Support\Str::slug($post->title)])
		);
	}

	public function test_it_can_generate_additional_query_parameters_on_the_show_route()
	{
		$post = Post::factory()->create();
		$this->assertEquals(
			$post->showRoute(['page' => 2]), 
			route('posts.show',[$post, \Illuminate\Support\Str::slug($post->title),'page'=> 2])
		);
	}

	public function test_it_will_redirect_if_slug_is_incorrect()
	{
		$post = Post::factory()->create(['title' => 'hello world']);
		$response = $this->get(route('posts.show',[$post,'foo-bar','page' => 2]));
		$response->assertRedirect($post->showRoute(['page' => 2]));
	}

}
