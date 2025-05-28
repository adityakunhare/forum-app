``<?php

namespace Tests\Feature\CommentController;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $post;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->post = Post::factory()->create();
    }

    public function test_it_can_store_comment()
    {

        $this->actingAs($this->user)
            ->post(route('posts.comments.store', $this->post), [
                'body' => 'This is a comment',
            ]);

        $this->assertDatabaseHas(Comment::class, [
            'user_id' => $this->user->id,
            'post_id' => $this->post->id,
            'body' => 'This is a comment'
        ]);
    }

    public function test_it_redirects_to_the_post_show_page()
    {

        $this->actingAs(User::factory()->create())
            ->post(route('posts.comments.store', $this->post), [
                'body' => 'This is a comment',
            ])->assertRedirect(route('posts.show', $this->post));
    }

    #[DataProvider('bodyProvider')]
    public function test_it_requires_a_valid_body($input)
    {
        $this->actingAs(User::factory()->create())
            ->post(route('posts.comments.store', $this->post), [
                'body' => $input
            ])
            ->assertInvalid('body');
    }

    public function test_a_guest_cannot_post_a_comment()
    {
        $this->post(route('posts.comments.store', $this->post), [
            'body' => 'This is a comment',
        ])->assertRedirect(route('login'));
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
}
