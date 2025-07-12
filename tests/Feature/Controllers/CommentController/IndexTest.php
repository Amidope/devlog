<?php

namespace Tests\Feature\Controllers\CommentController;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_comments(): void
    {
        $post = Post::factory()->create();
        $this->getJson(route('comments.index', $post))
            ->assertOk();
    }
}
