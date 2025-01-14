<?php

namespace App\Models;

use App\Base\Interfaces\HasChallenge;
use App\Base\Interfaces\HasStudent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChallengeSubmit extends Model implements HasStudent, HasChallenge
{
    use HasFactory;
    public $incrementing = false;
    public $keyType = 'char';
    protected $table = 'challenge_submits';
    protected $primaryKey = 'id';
    protected $fillable = [
        'student_id',
        'challenge_id',
        'image',
        'file',
        'link',
    ];

    /**
     * Get the student that owns the ChallengeSubmit
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the challenge that owns the ChallengeSubmit
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function challenge(): BelongsTo
    {
        return $this->belongsTo(Challenge::class);
    }
}
