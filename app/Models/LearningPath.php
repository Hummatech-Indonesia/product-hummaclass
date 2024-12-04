<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LearningPath extends Model
{
    use HasFactory;
    public $incrementing = false;
    public $keyType = 'char';
    protected $primaryKey = 'id';
    protected $table = 'learning_paths';
    protected $fillable = [
        'division_id',
        'class_level'
    ];
    /**
     * Get the division that owns the LearningPath
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }
    /**
     * Get all of the courseLearningPaths for the LearningPath
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function courseLearningPaths(): HasMany
    {
        return $this->hasMany(CourseLearningPath::class);
    }
}
