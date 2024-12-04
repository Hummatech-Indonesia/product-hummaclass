<?php

namespace App\Models;

use App\Base\Interfaces\HasDivision;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssessmentForm extends Model implements HasDivision
{
    use HasFactory;

    protected $table = 'assessment_forms';

    protected $fillable = ['class_level', 'division_id', 'indicator', 'type'];

    /**
     * division
     *
     * @return BelongsTo
     */
    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }
}
