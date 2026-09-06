<?php

namespace App\Models;

use App\Models\Concerns\ConvertsMarkdownToHtml;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Laravel\Scout\Attributes\SearchUsingFullText;
use Laravel\Scout\Attributes\SearchUsingPrefix;
use Laravel\Scout\Searchable;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory, ConvertsMarkdownToHtml, Searchable;

    protected $fillable = ["title", "body", "user_id", "html", "topic_id"];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class,'likeable');
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class); 
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function title(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => \Illuminate\Support\Str::title($value)
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

     /**
     * Get the indexable data array for the model.
     *
     * @return array<string, mixed>
     */
    #[SearchUsingFullText(['title'])]
    #[SearchUsingFullText(['body'])]
    public function toSearchableArray(): array
    {
        return [
            'title' => $this->title,
            'body' => $this->body
        ];
    }
}
