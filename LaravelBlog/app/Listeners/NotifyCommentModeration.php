<?php

namespace App\Listeners;

use App\Events\CommentCreated;
use Illuminate\Support\Facades\Log;

class NotifyCommentModeration
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
    public function handle(CommentCreated $event): void
    {
        Log::info('New comment needs moderation', [
            'comment_id' => $event->comment->id,
            'post_id' => $event->comment->post_id,
        ]);
    }
}
