<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use App\Events\PostPublished;

class PublishScheduledPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:publish-scheduled-posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish scheduled posts whose publish time has arrived';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $posts = Post::where('publication_state', Post::STATE_SCHEDULED)
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now())
                    ->get();

        foreach ($posts as $post) {
            $post->publication_state = Post::STATE_PUBLISHED;
            $post->status = Post::STATE_PUBLISHED;
            $post->save();
            event(new PostPublished($post));
            $this->info("Пост '{$post->title}' опубликован");
        }

        $this->info("Обработано постов: " . $posts->count());
        
        return 0;
    }
}
