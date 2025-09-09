<?php

namespace Tests\Feature\Controllers\PostController;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class DestroyTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private User $admin;
    private Post $post;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->admin = User::factory()->create([
            'is_admin' => true
        ]);
        $this->post = Post::factory()->create();
    }

    public function test_admin_can_delete_post(): void
    {
        $id = $this->post->id;
        $this->actingAs($this->admin)
            ->deleteJson(route('posts.destroy', $this->post))
            ->assertStatus(204);

        $this->assertDatabaseMissing('posts', ['id' => $id]);
    }

    public function test_non_admin_user_cannot_delete_post(): void
    {
        $this->deleteJson(route('posts.destroy', $this->post))
            ->assertUnauthorized();

        $this->actingAs($this->user)
            ->deleteJson(route('posts.destroy', $this->post))
            ->assertForbidden();

        $this->assertDatabaseHas('posts', $this->post->getAttributes());

    }
}
