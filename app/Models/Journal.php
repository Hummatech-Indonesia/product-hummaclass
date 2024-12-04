<?php

namespace App\Models;

use App\Base\Interfaces\HasClassroom;
use App\Base\Interfaces\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Journal extends Model implements HasUser, HasClassroom
{
    use HasFactory;
    public $incrementing = false;
    public $keyType = 'char';
    protected $table = 'journals';
    protected $primaryKey = 'id';
    protected $fillable = [
        'title',
        'description',
        'image',
        'user_id',
        'classroom_id',
    ];

    /**
     * Get the user that owns the Journal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the classroom that owns the Journal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }
}
