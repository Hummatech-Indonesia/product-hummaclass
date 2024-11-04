<?php

namespace App\Models;

use App\Base\Interfaces\HasEventDetails;
use App\Base\Interfaces\HasEventUsers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model implements HasEventDetails
{
    use HasFactory;
    public $incrementing = false;
    public $keyType = 'char';
    protected $table = 'events';
    protected $primaryKey = 'id';
    protected $fillable = [
        'image',
        'title',
        'slug',
        'description',
        'email_content',
        'location',
        'capacity',
        'price',
        'start_date',
        'end_date',
        'has_certificate',
        'is_online',
    ];
    /**
     * Get all of the eventDetails for the Event
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function eventDetails(): HasMany
    {
        return $this->hasMany(EventDetail::class);
    }
    /**
     * Get all of the eventUsers for the Event
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function UserEvents(): HasMany
    {
        return $this->hasMany(UserEvent::class);
    }

    /**
     * Get all of the eventAttendances for the Event
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function eventAttendances(): HasMany
    {
        return $this->hasMany(EventAttendance::class);
    }
}
