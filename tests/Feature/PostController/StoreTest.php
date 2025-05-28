<?php

namespace Tests\Feature\PostController;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    protected function validData()
    {
        return [
            'title' => 'Some title',
            'body' => 'Some body for this post.'
        ];
    }

    public function test_it_requires_authentication()
    {
        $this->post(route('posts.store'), [])->assertRedirect(route('login'));
    }

    public function test_it_stores_the_post()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
       
        $this->post(route('posts.store'), $this->validData());
        $this->assertDatabaseHas('posts', [...$this->validData(), 'user_id' => $user->id]);
    }

    public function test_it_redirects_to_the_post_show_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->post(route('posts.store'), $this->validData());
        $response->assertRedirect(route('posts.show', Post::latest('id')->first()->id));
    }
}
