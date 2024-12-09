<?php

namespace App\Models;

use App\Base\Interfaces\HasClassroom;
use App\Base\Interfaces\HasStudent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StudentClassroom extends Model implements HasClassroom, HasStudent
{
    use HasFactory;
    public $incrementing = false;
    public $keyType = 'char';
    protected $primaryKey = 'id';
    protected $table = 'student_classrooms';
    protected $fillable = [
        'student_id',
        'classroom_id'
    ];

    /**
     * student
     *
     * @return BelongsTo
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the classroom that owns the StudentClassroom
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }

    /**
     * Get all of the journalPresences for the StudentClassroom
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function journalPresences(): HasMany
    {
        return $this->hasMany(JournalPresence::class);
    }
}
