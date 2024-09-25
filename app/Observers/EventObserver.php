<?php

namespace App\Observers;

use App\Models\Event;
use Faker\Provider\Uuid;
use Illuminate\Support\Str;

class EventObserver
{
    /**
     * Method creating
     *
     * @param Event $event [explicite description]
     *
     * @return void
     */
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
        $event->slug = Str::slug($event->title);
    }
    /**
     * Method updating
     *
     * @param Event $event [explicite description]
     *
     * @return void
     */
    public function updating(Event $event): void
    {
        $event->slug = Str::slug($event->title);
    }
}
