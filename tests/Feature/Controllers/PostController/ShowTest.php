<?php

namespace Tests\Feature\Controllers\PostController;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    private Post $post;

    protected function setUp(): void
    {
        parent::setUp();
        $this->post = Post::factory()->create();
    }

    public function test_show_returns_post()
    {
        $this->getJson(route('posts.show', $this->post))
            ->assertOk();
    }
}
