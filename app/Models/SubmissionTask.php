<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubmissionTask extends Model
{
    use HasFactory;
    public $keyType = 'char';
    public $incrementing = false;
    protected $table = 'course_tasks';
    protected $primaryKey = 'id';
    protected $fillable = [
        'course_task_id',
        'user_id',
        'answer'
    ];
}
