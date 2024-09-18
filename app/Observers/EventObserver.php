<?php

namespace App\Observers;

use App\Models\Event;
use Faker\Provider\Uuid;

class EventObserver
{    
    /**
     * Method creating
     *
     * @param Event $event [explicite description]
     *
     * @return void
     */
    public function creating(Event $event): void
    {
        $event->id = Uuid::uuid();
    }
}
