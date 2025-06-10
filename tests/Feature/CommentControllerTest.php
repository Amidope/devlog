<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->post = Post::factory()->create();
    }

    public function testIndex(): void
    {
        $this->getJson(route('comments.index', $this->post))
            ->assertOk();
    }

    public function testStore(): void
    {
        $data = Comment::factory()
            ->recycle($this->user)
            ->recycle($this->post)
            ->make()
            ->toArray();
        $response = $this->actingAs($this->user)
            ->postJson(
                route('comments.store', ['post' => $this->post->id]),
                $data
            );
        $response->assertStatus(201);
        $this->assertDatabaseHas('comments', $data);
    }

    public function testUpdate(): void
    {
        $data = Comment::factory()->make()->toArray();
        $response = $this->patchJson(route('comments.update', $this->post), $data);
        $response->assertOk();
    }

    public function testDelete(): void
    {
        $comment = Comment::factory()->create();
        $id = $comment->id;
        $response = $this->deleteJson(route('comments.destroy', $comment));
        $response->assertStatus(204);
        $this->assertDatabaseMissing('comments', ['id' => $id]);
    }
}
