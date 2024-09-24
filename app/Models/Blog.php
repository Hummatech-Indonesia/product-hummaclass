<?php

namespace App\Models;

use App\Base\Interfaces\HasSubCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Blog extends Model implements HasSubCategory
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
        'views',
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
}
