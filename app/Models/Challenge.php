<?php

namespace App\Models;

use App\Base\Interfaces\HasChallengeSubmits;
use App\Base\Interfaces\HasClassroom;
use App\Base\Interfaces\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Challenge extends Model implements HasClassroom, HasUser, HasChallengeSubmits
{
    use HasFactory;
    public $incrementing = false;
    public $keyType = 'char';
    protected $table = 'challenges';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'classroom_id',
        'title',
        'slug',
        'description',
        'start_date',
        'end_date',
        'image_active',
        'file_active',
        'link_active',
    ];

    /**
     * Get the user that owns the Challenge
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the classroom that owns the Challenge
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }

    /**
     * Get all of the challengeSubmits for the Challenge
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function challengeSubmits(): HasMany
    {
        return $this->hasMany(ChallengeSubmit::class);
    }
}
