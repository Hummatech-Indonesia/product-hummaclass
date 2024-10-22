<?php

namespace App\Models;

use App\Base\Interfaces\HasModule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModuleTask extends Model implements HasModule
{
    use HasFactory;
    public $incrementing = false;
    public $keyType = 'char';
    protected $table = 'module_tasks';
    protected $primaryKey = 'id';
    protected $fillable = [
        'module_id',
        'question',
        'point',
        'description'
    ];

    /**
     * Get the module that owns the ModuleTask
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    /**
     * Get all of the submissionTask for the ModuleTask
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function submissionTask(): HasMany
    {
        return $this->hasMany(SubmissionTask::class);
    }
}
