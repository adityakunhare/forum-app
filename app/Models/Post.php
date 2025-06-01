<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;

    protected $fillable = ["title", "body", "user_id","html"];

    protected static function booted()
    {
        static::saving(
            fn(self $post) => $post->fill([
                'html' => str($post->body)->markdown()
            ])
        );
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function title(): Attribute
    {
        return Attribute::make(
            get: fn($value) => \Illuminate\Support\Str::title($value)
        );
    }
  
    public function showRoute(array $parameters = []): string
    {
        return route("posts.show", [
            "post" => $this->id,
            "slug" => \Illuminate\Support\Str::slug($this->title),
            ...$parameters
        ]);
    }
}
