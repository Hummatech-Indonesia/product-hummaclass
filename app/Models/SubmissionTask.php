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
    protected $table = 'submission_tasks';
    protected $primaryKey = 'id';
    protected $fillable = [
        'module_task_id',
        'user_id',
        'answer',
        'file'
    ];

    /**
     * Get the user that owns the SubmissionTask
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the moduleTask that owns the SubmissionTask
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function moduleTask(): BelongsTo
    {
        return $this->belongsTo(ModuleTask::class);
    }
}
