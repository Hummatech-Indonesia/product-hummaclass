<?php

namespace App\Models;

use App\Base\Interfaces\HasCourse;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseTask extends Model implements HasCourse
{
    use HasFactory;
    public $keyType = 'char';
    public $incrementing = false;
    protected $table = 'course_tasks';
    protected $primaryKey = 'id';
    protected $fillable = [
        'course_id',
        'number_of',
        'question'
    ];
    /**
     * Get the course that owns the CourseTask
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

}
