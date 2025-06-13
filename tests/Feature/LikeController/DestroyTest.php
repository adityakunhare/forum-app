<?php

namespace Tests\Feature\LikeController;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class DestroyTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_requires_authentication()
    {
        $likeable = Post::factory()->create();
        $this->delete(route('likes.destroy',[$likeable->getMorphClass(), $likeable->id]), [])
                        ->assertRedirect(route('login'));
    }

    public function test_it_allows_unliking_a_post_likeable(): void
    {
        $user = User::factory()->create();
        $likeable = Post::factory()->create(['likes_count' => 1]);
        $like = Like::factory()->for($user)->for($likeable,'likeable')->create();

        $this->actingAs($user);
        $this->from($likeable->showRoute());
        $this->delete(route('likes.destroy',[$likeable->getMorphClass(), $likeable->id]))
                    ->assertRedirect($likeable->showRoute()); 

        $this->assertDatabaseEmpty(Like::class);     

        $this->assertEquals($likeable->refresh()->likes_count, 0); 
         
    }

    public function test_it_allows_liking_a_comment_likeable(): void
    {
        $user = User::factory()->create();
        $likeable = Comment::factory()->create(['likes_count' =>  1]);
        $like = Like::factory()->for($user)->for($likeable,'likeable')->create();

        $this->actingAs($user);
        $this->from($likeable->showRoute());
        $this->delete(route('likes.destroy',[$likeable->getMorphClass(), $likeable->id]))
                    ->assertRedirect($likeable->showRoute()); 

        $this->assertDatabaseEmpty(Like::class);     

        $this->assertEquals($likeable->refresh()->likes_count, 0); 
         
    }

    public function test_it_prevents_unliking_something_you_havent_liked()
    {
        $likeable = Post::factory()->create();

        $this->actingAs(User::factory()->create());

        $this->delete(route('likes.destroy',[$likeable->getMorphClass(), $likeable->id]))
                    ->assertForbidden();
    }

    public function test_it_only_allows_liking_supported_models()
    {
        $user = User::factory()->create();

        $this->actingAs($user);
        $this->post(route('likes.store',[$user->getMorphClass(), $user->id]))         
            ->assertForbidden();
    }

    public function test_it_throughs_a_404_if_type_is_unsupported()
    {
        $this->actingAs(User::factory()->create());

        $this->post(route('likes.store',['foo', 1])) 
            ->assertNotFound();
    }


}
