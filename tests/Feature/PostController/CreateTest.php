<?php

namespace Tests\Feature\PostController;

use App\Http\Resources\TopicResource;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_it_requires_authentication()
    {
        $response = $this->get(route('posts.create')); 
        $response->assertRedirect(route('login'));
    }

    public function test_it_returns_the_correct_component()
    {
        
        $this->actingAs(User::factory()->create());
        $response = $this->get(route('posts.create')); 
        $response->assertComponent('Posts/Create');
    }

    public function test_it_passes_topics_to_the_create_page()
    {
        $topics = Topic::factory(3)->create();

        $this->actingAs(User::factory()->create());
        $this->get(route('posts.create'))
                    ->assertHasResource('topics', TopicResource::collection($topics));
    }
}
