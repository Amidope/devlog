<?php

namespace App\Services;

use App\Models\Post;

class PostService
{

    public function create(array $data): Post
    {
        return Post::create($data);
    }
}
