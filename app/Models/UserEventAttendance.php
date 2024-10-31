<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserEventAttendance extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'event_attendance_id',
        'is_attendance'
    ];


    /**
     * Get the eventAttendance that owns the UserEventAttendance
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function eventAttendance(): BelongsTo
    {
        return $this->belongsTo(EventAttendance::class);
    }
    /**
     * Get the user that owns the UserEventAttendance
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
