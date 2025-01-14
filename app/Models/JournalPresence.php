<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JournalPresence extends Model
{
    use HasFactory;
    public $incrementing = false;
    public $keyType = 'char';
    protected $table = 'journal_presences';
    protected $primaryKey = 'id';
    protected $fillable = [
        'journal_id',
        'status',
        'student_classroom_id',
    ];

    /**
     * Get the journal that owns the JournalPresence
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function journal(): BelongsTo
    {
        return $this->belongsTo(Journal::class);
    }

    /**
     * Get the studentClassroom that owns the JournalPresence
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function studentClassroom(): BelongsTo
    {
        return $this->belongsTo(StudentClassroom::class);
    }
}
