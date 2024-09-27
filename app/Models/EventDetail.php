<?php

namespace App\Models;

use App\Base\Interfaces\HasEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventDetail extends Model implements HasEvent
{
    use HasFactory;
    protected $fillable = [
        'event_id',
        'user',
        'start',
        'end',
        'session',
    ];
    /**
     * Get the event that owns the EventDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
