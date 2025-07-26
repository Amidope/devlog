<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;

class PostObserver
{
    private function clearPostsCache(): void
    {
        Cache::tags('posts')->flush();
    }
    /**
     * Handle the Post "created" event.
     */
    public function created(Post $post): void
    {
        $this->clearPostsCache();
    }

    /**
     * Handle the Post "updated" event.
     */
    public function updated(Post $post): void
    {
        $this->clearPostsCache();
    }

    /**
     * Handle the Post "deleted" event.
     */
    public function deleted(Post $post): void
    {
        $this->clearPostsCache();
    }
//
//    /**
//     * Handle the Post "restored" event.
//     */
//    public function restored(Post $post): void
//    {
//        //
//    }
//
//    /**
//     * Handle the Post "force deleted" event.
//     */
//    public function forceDeleted(Post $post): void
//    {
//        //
//    }
}
