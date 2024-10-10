<?php

namespace App\Models;

use App\Base\Interfaces\HasDiscussionAnswers;
use App\Base\Interfaces\HasDiscussionTags;
use App\Base\Interfaces\HasTags;
use App\Base\Interfaces\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Discussion extends Model implements HasUser, HasTags, HasDiscussionAnswers
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'module_id',
        'discussion_title',
        'discussion_question'
    ];
    /**
     * Get the user that owns the Discussion
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Get all of the tags for the Discussion
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tags(): HasMany
    {
        return $this->hasMany(Tag::class);
    }
    /**
     * Get all of the discussionAnswers for the Discussion
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function discussionAnswers(): HasMany
    {
        return $this->hasMany(DiscussionAnswer::class);
    }
}
