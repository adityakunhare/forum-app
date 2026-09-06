<?php

namespace Tests\Feature\PostController;

use App\Http\Resources\PostResource;
use App\Http\Resources\TopicResource;
use App\Models\Post;
use App\Models\Topic;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_passes_posts_to_the_view()
    {
        $posts = Post::factory(3)->create(); 
        $posts->load(['user','topic']);
        $this->get(route('posts.index'))
            ->assertHasPaginatedResource('posts', PostResource::collection($posts->reverse()));
    }


    public function test_it_can_filter_a_topic()
    {
        $general = Topic::factory()->create();
        $posts = Post::factory(2)->for($general)->create(); 
        $otherPosts = Post::factory(3)->create();

        $posts->load(['user','topic']);
        $this->get(route('posts.index', ['topic' => $general]))
            ->assertHasPaginatedResource('posts', PostResource::collection($posts->reverse()));
    }


    public function test_it_passes_selected_topic_to_the_view()
    {
        $topic = Topic::factory()->create();

        $this->get(route('posts.index', ['topic' => $topic]))
            ->assertHasResource('selectedTopic', TopicResource::make($topic));
    }

    public function test_it_passes_topics_to_the_view()
    {
        $topics =  Topic::factory(3)->create(); 

        $this->get(route('posts.index'))
                ->assertHasResource('topics', TopicResource::collection($topics));
    } 

}
