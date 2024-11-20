<?php

namespace App\Observers;

use App\Models\Discussion;

class DiscussionObserver
{
    /**
     * Handle the Discussion "created" event.
     */
    public function creating(Discussion $discussion): void
    {
        $discussion->discussion_title = htmlspecialchars($discussion->discussion_title);
        $discussion->discussion_question = htmlspecialchars($discussion->discussion_question);
    }

    /**
     * Handle the Discussion "updated" event.
     */
    public function updating(Discussion $discussion): void
    {
        $discussion->discussion_title = htmlspecialchars($discussion->discussion_title);
        $discussion->discussion_question = htmlspecialchars($discussion->discussion_question);
    }
}
