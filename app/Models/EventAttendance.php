<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventAttendance extends Model
{
    use HasFactory;

    protected $fillable = ['event_id', 'attendance_date', 'attendance_link'];

    /**
     * Get the event that owns the EventAttendance
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Get all of the userEventAttendance for the EventAttendance
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userEventAttendance(): HasMany
    {
        return $this->hasMany(UserEventAttendance::class);
    }
}
