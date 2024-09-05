<?php

namespace App\Models;

use App\Base\Interfaces\HasCourseTask;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubmissionTask extends Model implements HasCourseTask
{
    use HasFactory;
    public $keyType = 'char';
    public $incrementing = false;
    protected $table = 'course_tasks';
    protected $primaryKey = 'id';
    protected $fillable = [
        'course_task_id',
        'user_id',
        'answer'
    ];
    /**
     * Get the courseTask that owns the SubmissionTask
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function courseTask(): BelongsTo
    {
        return $this->belongsTo(CourseTask::class);
    }
}
