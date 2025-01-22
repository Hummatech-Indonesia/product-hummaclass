<?php

namespace App\Observers;

use App\Models\Header;

class HeaderObserver
{
    /**
     * Handle the Header "created" event.
     */
    public function creating(Header $header): void
    {
        $header->title = htmlspecialchars($header->title);
        $header->description = htmlspecialchars($header->description);
    }

    /**
     * Handle the Header "updated" event.
     */
    public function updating(Header $header): void
    {
        $header->title = htmlspecialchars($header->title);
        $header->description = htmlspecialchars($header->description);
    }
}
