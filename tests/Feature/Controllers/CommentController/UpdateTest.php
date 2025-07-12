<?php

namespace Tests\Feature\Controllers\CommentController;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    protected User $commentAuthor;
    protected Post $post;
    protected Comment $comment;
    protected array $commentData;

    protected function setUp(): void
    {
        parent::setUp();
        $this->commentAuthor = User::factory()->create();
        $this->post = Post::factory()->create();
        $this->comment = Comment::factory()
            ->recycle($this->post)
            ->for($this->commentAuthor)
            ->create();

        $this->commentData = Comment::factory()
            ->recycle($this->post)
            ->make()
            ->toArray();
    }

    public function test_author_can_update_comment(): void
    {
        $this->actingAs($this->commentAuthor)
            ->patchJson(
                route('comments.update', $this->comment),
                $this->commentData
            )
            ->assertOk();
        $this->assertDatabaseHas('comments', $this->commentData);
    }

    public function test_non_author_cannot_update_comment(): void
    {
        $this->patchJson(
            route('comments.update', $this->comment),
            $this->commentData
        )->assertUnauthorized();

        $this->commentData['content'] = 'Why do we all have to wear these ridiculous ties?';

        $this->actingAs(User::factory()->create())
            ->patchJson(
                route('comments.update', $this->comment),
                $this->commentData
            )
            ->assertForbidden();
    }
}
