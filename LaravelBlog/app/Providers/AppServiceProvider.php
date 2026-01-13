<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Events\CommentCreated;
use App\Listeners\NotifyAdminAboutComment;
use App\Listeners\UpdatePostStats;
use App\Events\PostPublished;
use App\Listeners\LogPostPublished;
use Illuminate\Support\Facades\Event;

class AppServiceProvider extends ServiceProvider
{
    protected $listen = [
    CommentCreated::class => [
        NotifyAdminAboutComment::class,
        UpdatePostStats::class,
    ],
    PostPublished::class => [
        LogPostPublished::class,
    ],
];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register event listeners (app keeps listeners here)
        Event::listen(CommentCreated::class, [NotifyAdminAboutComment::class, 'handle']);
        Event::listen(CommentCreated::class, [UpdatePostStats::class, 'handle']);
        Event::listen(PostPublished::class, [LogPostPublished::class, 'handle']);
    }
}
