<?php

namespace Tests\Feature\Controllers\PostController;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Resources\Json\JsonResource;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_it_should_return_correct_component()
    {
        // $this->withoutVite();
        $this->withoutExceptionHandling();

        AssertableInertia::macro('hasResource', function(string $key, JsonResource $resource) {
            $props = $this->toArray()['props'];
            $post = $props['post'];
            $compiledResource = $resource->response()->getData(true);

            TestCase::assertArrayHasKey($key, $props);
            TestCase::assertEquals($compiledResource, $post);
        });

        $posts = Post::factory(3)->create();

        $this->get(route('posts.index'))       
            ->assertInertia(
                fn(AssertableInertia $inertia) => $inertia
                    ->hasResource('post', PostResource::make($posts->first()))
            );
    }
}
