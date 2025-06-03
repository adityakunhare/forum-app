<?php

namespace App\Support;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

class PostFixtures
{

    protected static Collection $fixtures;

    public static function getFixtures(): Collection
    {
        return self::$fixtures ??= collect(
            File::files(database_path('factories/Fixtures/Posts'))
        )
        ->map(fn($file) => $file->getContents())
        ->map(fn(string $contents) => str($contents)->explode("\n",2))
        ->map(fn(Collection $parts) => [
            'title' => str($parts[0])->trim()->after('# '),
            'body' => str($parts[1])->trim(),
        ]);
    }
}
