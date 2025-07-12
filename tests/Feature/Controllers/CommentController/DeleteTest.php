<?php

namespace Tests\Feature\Controllers\CommentController;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    use RefreshDatabase;

    protected User $commentAuthor;
    protected Post $post;
    protected Comment $comment;

    protected function setUp(): void
    {
        parent::setUp();
        $this->commentAuthor = User::factory()->create();
        $this->post = Post::factory()->create();
        $this->comment = Comment::factory()
            ->recycle($this->post)
            ->for($this->commentAuthor)
            ->create();
    }

    public function test_author_can_delete_comment(): void
    {
        $id = $this->comment->id;
        $this->actingAs($this->commentAuthor)
            ->deleteJson(route('comments.destroy', $this->comment))
            ->assertStatus(status: 204);
        $this->assertDatabaseMissing('comments', ['id' => $id]);

    }

    public function test_non_author_cannot_delete_comment(): void
    {
        $this->deleteJson(route('comments.destroy', $this->comment))
            ->assertUnauthorized();

        $this->actingAs(User::factory()->create())
            ->deleteJson(route('comments.destroy', $this->comment))
            ->assertForbidden();
    }
}
