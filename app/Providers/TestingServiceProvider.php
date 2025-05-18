<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Testing\TestResponse;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class TestingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if(!$this->app->runningUnitTests()){
            return;
        }

         AssertableInertia::macro('hasResource', function(string $key, JsonResource $resource) {
            $props = $this->toArray()['props'];
            $post = $props['post'];
            $compiledResource = $resource->response()->getData(true);

            TestCase::assertArrayHasKey($key, $props);
            TestCase::assertEquals($compiledResource, $post);
            return $this;
        });


        AssertableInertia::macro('hasPaginatedResource', function(string $key, ResourceCollection $resource) {
            $props = $this->toArray()['props'];
            $post = $props[$key];

            $compiledNewResource = $resource->response()->getData(true);

            TestCase::assertArrayHasKey($key, $props);
            TestCase::assertEquals($compiledNewResource, $post['data']);
            TestCase::assertArrayHasKey('data',$post);
            TestCase::assertArrayHasKey('links',$post);
            TestCase::assertArrayHasKey('meta',$post);
            
            return $this;
        });

       TestResponse::macro('assertHasResource', function(string $key, JsonResource $resource){
            return $this->assertInertia(fn(AssertableInertia $inertia) => $inertia->hasResource($key,$resource));
       }); 

       TestResponse::macro('assertHasPaginatedResource', function(string $key, ResourceCollection $resource){
            return $this->assertInertia(fn(AssertableInertia $inertia) => $inertia->hasPaginatedResource($key,$resource));
       }); 


       TestResponse::macro('assertComponent', function(string $component){
            return $this->assertInertia(fn(AssertableInertia $inertia) => $inertia->component($component,true));
       }); 

    }
}
