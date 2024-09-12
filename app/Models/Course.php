<?php

namespace App\Models;

use App\Base\Interfaces\HasModules;
use App\Base\Interfaces\HasSubCategory;
use App\Base\Interfaces\HasUserCourses;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model implements HasSubCategory, HasModules, HasUserCourses
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
    /**
     * Get all of the modules for the Course
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function modules(): HasMany
    {
        return $this->hasMany(Module::class);
    }

    /**
     * Get all of the courseReviews for the Course
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function courseReviews(): HasMany
    {
        return $this->hasMany(CourseReview::class);
    }

    /**
     * Get all of the userCourses for the Course
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userCourses(): HasMany
    {
        return $this->hasMany(UserCourse::class);
    }
}
