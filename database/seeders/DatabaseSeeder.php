<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\Topic;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(TopicSeeder::class);
        $topics = Topic::all();

        $users = User::factory(10)->create();
        $posts = Post::factory(200)
                    ->withFixture()
                    ->has(Comment::factory(15)->recycle($users))
                    ->recycle([$users,$topics])
                    ->create();

        Comment::factory(10)->recycle($users)->recycle([$posts,$topics])->create();
        $aditya = User::factory()
                    ->has(Post::factory(40)->recycle($topics)->withFixture())
                    ->has(Comment::factory(128)->recycle($posts))
                    ->has(Like::factory()->forEachSequence(
                        ...$posts->random(100)->map(fn(Post $post) => ['likeable_id' => $post])
                    ))
                    ->create([
                        'name' => 'Aditya Kunhare',
                        'email' => 'honey.kunhare@gmail.com'
                    ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
