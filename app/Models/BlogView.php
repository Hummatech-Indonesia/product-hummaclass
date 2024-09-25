<?php

namespace App\Models;

use App\Base\Interfaces\HasBlog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogView extends Model implements HasBlog
{
    use HasFactory;

    protected $fillable = [
        'blog_id',
        'view'
    ];
    /**
     * Get the blog that owns the BlogView
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function blog(): BelongsTo
    {
        return $this->belongsTo(Blog::class);
    }
}
