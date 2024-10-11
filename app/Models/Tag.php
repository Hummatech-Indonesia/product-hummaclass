<?php

namespace App\Models;

use App\Base\Interfaces\HasDiscussions;
use App\Base\Interfaces\HasDiscussionTags;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tag extends Model implements HasDiscussionTags
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];
    /**
     * Get all of the discussionTags for the Tag
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function discussionTags(): HasMany
    {
        return $this->hasMany(DiscussionTag::class);
    }
}
