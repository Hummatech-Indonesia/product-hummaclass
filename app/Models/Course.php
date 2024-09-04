<?php

namespace App\Models;

use App\Base\Interfaces\HasSubCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Course extends Model implements HasSubCategory
{
    use HasFactory;

    public $incrementing = false;
    public $keyType = 'char';
    protected $table = 'courses';
    protected $primaryKey = 'id';
    protected $fillable = ['sub_category_id', 'title', 'sub_title', 'description', 'is_premium', 'price', 'photo'];

    /**
     * Method subCategory
     *
     * @return BelongsTo
     */
    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class);
    }
}
