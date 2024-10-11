<?php

namespace App\Models;

use App\Base\Interfaces\HasDiscussionAnswers;
use App\Base\Interfaces\HasDiscussionTags;
use App\Base\Interfaces\HasModule;
use App\Base\Interfaces\HasTags;
use App\Base\Interfaces\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Discussion extends Model implements HasUser, HasDiscussionTags, HasDiscussionAnswers, HasModule
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'module_id',
        'discussion_title',
        'discussion_question'
    ];
    /**
     * Get the module that owns the Discussion
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }
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
     * Get all of the discussionTags for the Discussion
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function discussionTags(): HasMany
    {
        return $this->hasMany(DiscussionTag::class);
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
