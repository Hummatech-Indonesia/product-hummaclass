<?php

namespace App\Models;

use App\Base\Interfaces\HasAssesmentForm;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssesmentFormStudent extends Model implements HasAssesmentForm
{
    use HasFactory;

    protected $table = 'assesment_form_students';

    protected $fillable = ['assessment_form_id', 'value', 'student_id'];
    public $keyType = 'char';
    public $incrementing = false;
    protected $primaryKey = 'id';

    public function assessmentForm(): BelongsTo
    {
        return $this->belongsTo(AssessmentForm::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
