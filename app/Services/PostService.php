<?php

namespace App\Services;

use App\Models\Post;

class PostService
{

    public function create(array $data): Post
    {
        return Post::create($data);
    }

    public function update(array $data, Post $post)
    {
        $post->update($data);
    }

    public function delete(Post $post): void
    {
        $post->delete();
    }
}
