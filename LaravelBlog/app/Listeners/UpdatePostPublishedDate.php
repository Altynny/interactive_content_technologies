<?php

namespace App\Listeners;

use App\Events\PostPublished;

class UpdatePostPublishedDate
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PostPublished $event): void
    {
        if (!$event->post->published_at) {
            $event->post->update(['published_at' => now()]);
        }
    }
}
