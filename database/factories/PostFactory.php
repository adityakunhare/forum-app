<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{

    protected static Collection $fixtures;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
             'user_id' => User::factory(),
             'title' => str(fake()->sentence)->beforeLast('.')->title(),
             'body' => Collection::times(4, fn() => fake()->realText(1250))->join(PHP_EOL.PHP_EOL),
        ];
    }

    public function withFixture(): static 
    {
        $posts =  static::getFixtures()
                    ->map(fn(string $contents) => str($contents)->explode("\n",2))
                    ->map(fn(Collection $parts) => [
                        'title' => str($parts[0])->trim()->after('# '),
                        'body' => $parts[1]
                    ]);

        return $this->sequence(...$posts);
    }

    protected static function getFixtures(): Collection
    {
        return self::$fixtures ??= collect(File::files(database_path('factories/Fixtures/Posts')))
                    ->map(fn ($file) => $file->getContents());
    }


}
