<?php

namespace Tests\Feature\CommentController;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DestroyTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_requires_authentication()
    {
        $this->delete(route('comments.destroy', Comment::factory()->create()))
            ->assertRedirect(route('login'));
    }

    public function test_it_can_delete_a_comment()
    {
        $comment = Comment::factory()->create();

        $this->actingAs($comment->user);
        $this->delete(route('comments.destroy', $comment));

        $this->assertModelMissing($comment);
    }

    public function test_it_redirects_back_to_post()
    {
        $comment = Comment::factory()->create();

        $this->actingAs($comment->user);
        $this->delete(route('comments.destroy', $comment))
            // ->assertRedirect(route('posts.show', Post::find($comment->post_id)));
            ->assertRedirect($comment->post->showRoute());
    }

    public function test_it_prevents_deleting_a_comment_you_didnot_create()
    {

        $comment = Comment::factory()->create();
        $anotherComment = Comment::factory()->create();

        $this->actingAs($comment->user);
        $this->delete(route('comments.destroy', $anotherComment));

        $this->assertModelExists($anotherComment);
    }

    public function test_it_prevents_deleting_a_comment_posted_over_an_hour_ago()
    {
        $this->freezeTime();
        $comment = Comment::factory()->create();
        $this->travel(1)->hour();

        $this->actingAs($comment->user);
        $this->delete(route('comments.destroy', $comment));

        $this->assertModelExists($comment);
    }

    public function test_it_redirects_to_show_page_with_page_query_parameter()
    {
        $comment = Comment::factory()->create();

        $this->actingAs($comment->user);
        $this->delete(route('comments.destroy', ['comment' => $comment, 'page' => 2]))
                // ->assertRedirect(route('posts.show', ['post' => $comment->post_id, 'page' => 2]));
                ->assertRedirect($comment->post->showRoute(['page' => 2]));
    }
}
