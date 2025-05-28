<?php

namespace Tests\Feature\PostController;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateTest extends TestCase
{
    public function test_it_requires_authentication()
    {
        $response = $this->get(route('posts.create')); 
        $response->assertRedirect(route('login'));
    }

    public function test_it_returns_the_correct_component()
    {
        $this->withoutExceptionHandling();
        
        $this->actingAs(User::factory()->create());
        $response = $this->get(route('posts.create')); 
        $response->assertComponent('Posts/Create');
    }
}
