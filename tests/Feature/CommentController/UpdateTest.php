<?php

namespace Tests\Feature\CommentController;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_requires_authentication()
    {
        $this->patch(route('comments.update', Comment::factory()->create()))
            ->assertRedirect(route('login'));
    }

    public function test_it_can_update_a_comment()
    {
        $comment = Comment::factory()->create();
        $this->actingAs($comment->user);
        $newComment = 'This is the new comment';

        $this->patch(route('comments.update', $comment), [
            'body' => $newComment
        ]);

        $this->assertDatabaseHas(Comment::class,[
            'user_id' => $comment->user_id,
            'body' => $newComment
        ]);
    }

    public function test_it_redirects_to_the_correct_page_of_comments()
    {
        $comment = Comment::factory()->create();

        $this->actingAs($comment->user)
            ->patch(route('comments.update', ['comment' => $comment, 'page' => 2]), [
                'body' => 'This is my new comment',
            ])->assertRedirect($comment->post->showRoute(['page' => 2]));
    }

    #[DataProvider('bodyProvider')]
    public function test_it_requires_valid_body($input)
    {
        $comment = Comment::factory()->create();

       $this->actingAs($comment->user)
            ->patch(route('comments.update', $comment), [
                'body' =>  $input 
            ])->assertInvalid('body');
    } 

    public static function bodyProvider()
    {
        return [
            '#null' => [null],
            '#23' => [23],
            '#2.5' => [2.5],
            '#2501' => [str_repeat('a', 2501)]
        ];
    }    

    public function test_it_cannot_update_a_comment_from_another_user()
    {
        $comment = Comment::factory()->create();

        $this->actingAs(User::factory()->create());
        $this->patch(route('comments.update', ['comment' => $comment]), [
            'body' => 'This is my new comment',
        ])->assertForbidden();
    }
}
