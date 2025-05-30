<?php

namespace Tests\Feature\PostController;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    protected function validData()
    {
        return [
            'title' => 'Some title',
            'body' => str_repeat('Some body for this post.',50)
        ];
    }

    public function test_it_requires_authentication()
    {
        $this->post(route('posts.store'), [])->assertRedirect(route('login'));
    }

    public function test_it_stores_the_post()
    {
        $this->withoutExceptionHandling();
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
        $response->assertRedirect(Post::latest('id')->first()->showRoute());
    }

    
    #[DataProvider('data')] 
    public function test_it_requires_a_valid_data($badData, $errors)
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->post(route('posts.store'), array_merge($this->validData(), $badData))
            ->assertSessionHasErrors($errors);
    }

    public static function data()
    {
        return [
            'title #null' => [['title' => null], 'title'],
            'title #23'=> [['title' => 23], 'title'],
            'title #true' => [['title' => true], 'title'],
            'title #empty' => [['title' => ''], 'title'],
            'title #2.5' => [['title' => 2.5], 'title'],
            'title #2501' => [['title' => str_repeat('a', 2501)], 'title'],
            'body #null' => [['body' => null], 'body'],
            'body #23'=> [['body' => 23], 'body'],
            'body #true' => [['body' => true], 'body'],
            'body #empty' => [['body' => ''], 'body'],
            'body #2.5' => [['body' => 2.5], 'body'],
            'body #2501' => [['body' => str_repeat('a', 2501)], 'body'],
        ];
    }
}
