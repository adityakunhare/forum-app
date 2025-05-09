<?php

namespace Tests\Feature\Controllers\PostController;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use LazilyRefreshDatabase;
    // use RefreshDatabase;

    public function test_it_should_return_correct_component()
    {
        $this->get(route('posts.index'))
                ->assertComponent('Posts/Index');  
    }


    public function test_passess_posts_to_view()
    {
        $this->get(route('posts.index')) 
                ->assertInertia(fn (AssertableInertia $inertia) => $inertia 
                        ->component('Posts/Index',true)
                );
    }




}
