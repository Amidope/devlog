<?php

namespace Tests\Feature\Controllers\CommentController;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Post $post;
    protected array $commentData;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->post = Post::factory()->create();
        $this->commentData = Comment::factory()
            ->recycle($this->post)
            ->make()
            ->toArray();
    }

    public function test_user_can_create_comment(): void
    {
        $this->actingAs($this->user)
            ->postJson(
                route('comments.store', ['post' => $this->post->id]),
                $this->commentData
            )
            ->assertCreated();
        $this->assertDatabaseHas('comments', $this->commentData);
    }

    public function test_guest_cannot_create_comment(): void
    {
        $this->postJson(
            route('comments.store', ['post' => $this->post->id]),
            $this->commentData
        )
        ->assertUnauthorized();
    }
}
