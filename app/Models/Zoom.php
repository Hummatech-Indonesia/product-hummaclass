<?php

namespace App\Models;

use App\Base\Interfaces\HasClassroom;
use App\Base\Interfaces\HasSchool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Zoom extends Model implements HasSchool, HasClassroom
{
    use HasFactory;
    public $incrementing = false;
    public $keyType = 'char';
    protected $table = 'zooms';
    protected $primaryKey = 'id';
    protected $fillable = [
        'title',
        'slug',
        'school_id',
        'classroom_id',
        'user_id',
        'link',
        'date',
    ];
    
    /**
     * Get the classroom that owns the Zoom
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }

    /**
     * Get the school that owns the Zoom
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Get the mentor that owns the Zoom
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mentor(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
