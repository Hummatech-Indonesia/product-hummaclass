<?php

namespace App\Models;

use App\Base\Interfaces\HasBlogViews;
use App\Base\Interfaces\HasSubCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Blog extends Model implements HasSubCategory, HasBlogViews
{
    use HasFactory;
    public $incrementing = false;
    public $keyType = 'char';
    protected $table = 'blogs';
    protected $primaryKey = 'id';
    protected $fillable = [
        'title',
        'thumbnail',
        'description',
        'sub_category_id',
    ];

    /**
     * Get the subCategory that owns the Blog
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class);
    }
    /**
     * Get all of the blogViews for the Blog
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function blogViews(): HasMany
    {
        return $this->hasMany(BlogView::class);
    }
}
