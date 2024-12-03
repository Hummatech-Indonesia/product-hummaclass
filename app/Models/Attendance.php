<?php

namespace App\Models;

use App\Base\Interfaces\HasClassroom;
use App\Base\Interfaces\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attendance extends Model implements HasUser, HasClassroom
{
    use HasFactory;
    public $incrementing = false;
    public $keyType = 'char';
    protected $table = 'attendances';
    protected $primaryKey = 'id';
    protected $fillable = [
        'title',
        'slug',
        'user_id',
        'classroom_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }

    /**
     * Get all of the attendanceStudents for the Attendance
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attendanceStudents(): HasMany
    {
        return $this->hasMany(AttendanceStudent::class);
    }
}


