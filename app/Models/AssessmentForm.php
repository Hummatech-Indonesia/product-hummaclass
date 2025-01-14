<?php

namespace App\Models;

use App\Base\Interfaces\HasDivision;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AssessmentForm extends Model implements HasDivision
{
    use HasFactory;

    protected $table = 'assessment_forms';

    protected $fillable = ['class_level', 'division_id', 'indicator', 'type'];
    public $keyType = 'char';
    protected $primaryKey = 'id';
    public $incrementing = false;


    /**
     * division
     *
     * @return BelongsTo
     */
    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    /**
     * Get all of the assesmentFormStudents for the AssessmentForm
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function assesmentFormStudents(): HasMany
    {
        return $this->hasMany(AssesmentFormStudent::class);
    }
}
