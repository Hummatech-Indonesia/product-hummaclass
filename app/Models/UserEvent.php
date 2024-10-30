<?php

namespace App\Models;

use App\Models\User;
use App\Models\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserEvent extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'event_id', 'has_certificate'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Get the event that owns the Userevent
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Get the certificate associated with the UserEvent
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function certificate(): HasOne
    {
        return $this->hasOne(Certificate::class);
    }
}
