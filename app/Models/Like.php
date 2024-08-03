<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Like extends Model
{
    use HasFactory;

    /**
     * The post that the like belongs to.
     *
     * @return BelongsTo<Post, Like>
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * The user that the like belongs to.
     *
     * @return BelongsTo<User, Like>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
