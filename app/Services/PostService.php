<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;

class PostService
{
    public function getPostsPage(int $page)
    {
        return Cache::tags('posts')->remember(
            "posts_page_{$page}",
            600,
            fn() => Post::latest('created_at')->paginate(10)
        );
    }

    public function create(array $data): Post
    {
        return Post::create($data);
    }

    public function update(array $data, Post $post): void
    {
        $post->update($data);
    }

    public function delete(Post $post): void
    {
        $post->delete();
    }
}
