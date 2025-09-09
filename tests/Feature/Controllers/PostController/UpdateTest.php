<?php

namespace Tests\Feature\Controllers\PostController;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class UpdateTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private User $admin;
    private array $postData;
    private Post $post;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->admin = User::factory()->create([
            'is_admin' => true
        ]);
        $this->postData = Post::factory()->make()->toArray();
        $this->post = Post::factory()->create();
    }

    public function test_admin_can_update_post(): void
    {
        $this->actingAs($this->admin)
            ->patchJson(route('posts.update', $this->post), $this->postData)
            ->assertOk();
        $this->assertDatabaseHas('posts', $this->postData);
    }

    public function test_non_admin_user_cannot_update_post()
    {
        $this->actingAs($this->user)
            ->patchJson(route('posts.update', $this->post), $this->postData)
            ->assertForbidden();
            
        $this->assertDatabaseHas('posts', $this->post->getAttributes());
    }
}
