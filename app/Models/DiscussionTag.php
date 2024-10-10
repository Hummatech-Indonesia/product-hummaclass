<?php

namespace App\Models;

use App\Base\Interfaces\HasDiscussion;
use App\Base\Interfaces\HasTag;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiscussionTag extends Model implements HasDiscussion, HasTag
{
    use HasFactory;
    protected $fillable = [
        'tag_id',
        'discussion_id'
    ];
    /**
     * Get the discussion that owns the DiscussionTag
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function discussion(): BelongsTo
    {
        return $this->belongsTo(Discussion::class);
    }
    /**
     * Get the tag that owns the DiscussionTag
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class);
    }
}
