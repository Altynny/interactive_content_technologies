<?php

namespace App\Listeners;

use App\Events\PostPublished;
use Illuminate\Support\Facades\Log;

class LogPostPublished
{
    /**
     * Handle the event.
     */
    public function handle(PostPublished $event): void
    {
        Log::info('Пост опубликован автоматически: ' . $event->post->id . ' — ' . $event->post->title);
    }
}
