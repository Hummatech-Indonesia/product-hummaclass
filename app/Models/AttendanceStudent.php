<?php

namespace App\Models;

use App\Base\Interfaces\HasClassroom;
use App\Base\Interfaces\HasStudent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceStudent extends Model implements HasStudent
{
    use HasFactory;
    public $incrementing = false;
    public $keyType = 'char';
    protected $table = 'attendance_students';
    protected $primaryKey = 'id';
    protected $fillable = [
        'student_id',
        'attendance_id',
    ];

    /**
     * Get the student that owns the AttendanceStudent
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the classroom that owns the AttendanceStudent
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function attendance(): BelongsTo
    {
        return $this->belongsTo(Attendance::class);
    }
}
