<?php

namespace App\Models;

use App\Base\Interfaces\HasModule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Quiz extends Model implements HasModule
{
    use HasFactory;
    public $keyType = 'char';
    public $incrementing = false;
    protected $table = 'quizzes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'module_id',
        'title',
        'slug',
        'total_question',
    ];
    /**
     * Get the module that owns the Quiz
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }
}
