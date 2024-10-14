<?php

namespace App\Models;

use App\Base\Interfaces\HasDiscussion;
use App\Base\Interfaces\HasDiscussionAnswer;
use App\Base\Interfaces\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiscussionAnswer extends Model implements HasDiscussionAnswer, HasDiscussion, HasUser
{
    use HasFactory;

    protected $fillable = [
        'answer',
        'discussion_answer_id',
        'discussion_id',
        'user_id'
    ];

    /**
     * Get the discussionAnswer that owns the DiscussionAnswer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function discussionAnswer(): BelongsTo
    {
        return $this->belongsTo(DiscussionAnswer::class, 'foreign_key', 'other_key');
    }
    /**
     * Get the discussion that owns the DiscussionAnswer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function discussion(): BelongsTo
    {
        return $this->belongsTo(Discussion::class);
    }
    /**
     * Get the user that owns the DiscussionAnswer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
