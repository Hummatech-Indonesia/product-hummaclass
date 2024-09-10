<?php

namespace App\Models;

use App\Base\Interfaces\HasCourse;
use App\Base\Interfaces\HasCourseVoucherUsers;
use App\Base\Interfaces\HasUsers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CourseVoucher extends Model implements HasCourse,HasCourseVoucherUsers
{
    use HasFactory;
    public $incrementing = false;
    public $keyType = 'char';
    protected $primaryKey = 'id';
    protected $table = 'course_vouchers';
    protected $fillable = [
        'course_id',
        'usage_limit',
        'code',
        'discount'
    ];
    /**
     * Get the course that owns the CourseVoucher
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
    /**
     * Get all of the courseVoucherUsers for the CourseVoucher
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function courseVoucherUsers(): HasMany
    {
        return $this->hasMany(CourseVoucherUser::class);
    }
}
