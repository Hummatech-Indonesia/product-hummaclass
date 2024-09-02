<?php

namespace App\Models;

use App\Base\Interfaces\HasUserCourse;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseReview extends Model implements HasUserCourse
{
    use HasFactory;

    protected $fillable = ['user_course_id', 'review', 'rating'];

    /**
     * Get the userCourse that owns the CourseReview
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userCourse(): BelongsTo
    {
        return $this->belongsTo(UserCourse::class);
    }

}
