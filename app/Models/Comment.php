<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'message',
        'post_id',
    ];

     /**
     * Get the user that owns the comment.
     *
     * @return BelongsTo<User,Comment>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

     /**
     * Get the post that owns the comment.
     *
     * @return BelongsTo<Post,Comment>
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
