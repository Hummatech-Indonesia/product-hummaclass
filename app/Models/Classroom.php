<?php

namespace App\Models;

use App\Base\Interfaces\HasChallenges;
use App\Base\Interfaces\HasDivision;
use App\Base\Interfaces\HasSchool;
use App\Base\Interfaces\HasSchoolYear;
use App\Base\Interfaces\HasTeacher;
use App\Base\Interfaces\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classroom extends Model implements HasSchool, HasDivision, HasUser, HasTeacher, HasSchoolYear, HasChallenges
{
    use HasFactory;
    public $incrementing = false;
    public $keyType = 'char';
    protected $primaryKey = 'id';
    protected $table = 'classrooms';
    protected $fillable = [
        'school_id',
        'division_id',
        'school_year_id',
        'teacher_id',
        'user_id',
        'name',
        'class_level'
    ];
    /**
     * Get the school that owns the Classroom
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
    /**
     * Get the division that owns the Classroom
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    /**
     * user
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * teacher
     *
     * @return BelongsTo
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * schoolYear
     *
     * @return BelongsTo
     */
    public function schoolYear(): BelongsTo
    {
        return $this->belongsTo(SchoolYear::class);
    }

    /**
     * schoolYear
     *
     * @return BelongsTo
     */
    public function challenges(): HasMany
    {
        return $this->hasMany(Challenge::class);
    }
}
