<?php

namespace App\Models;

use App\Models\Concerns\ConvertsMarkdownToHtml;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Comment extends Model
{
    /** @use HasFactory<\Database\Factories\CommentFactory> */
    use HasFactory, ConvertsMarkdownToHtml;

    protected $with = ['user'];

    protected $fillable = [
        'body', 'user_id', 'post_id','html'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class,'likeable');
    }
}
