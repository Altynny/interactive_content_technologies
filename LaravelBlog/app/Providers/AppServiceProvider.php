<?php

namespace App\Providers;

use App\Events\CommentCreated;
use App\Events\PostPublished;
use App\Listeners\NotifyCommentModeration;
use App\Listeners\UpdatePostPublishedDate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected $listen = [
        PostPublished::class => [
            UpdatePostPublishedDate::class,
        ],
        CommentCreated::class => [
            NotifyCommentModeration::class,
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
        //
    }
}
