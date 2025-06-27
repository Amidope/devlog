<?php

namespace Tests\Feature\Controllers\PostController;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class StoreTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private User $admin;
    private array $postData;


    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->admin = User::factory()->create([
            'is_admin' => true
        ]);
        $this->postData = Post::factory()->make()->toArray();
    }

    public function test_admin_can_create_post(): void
    {
        $this->actingAs($this->admin)
            ->postJson(route('posts.store'), $this->postData)
            ->assertStatus(201);

        $this->assertDatabaseHas('posts', $this->postData);
    }

    public function test_non_admin_user_cannot_create_post(): void
    {
        $this->postJson(route('posts.store'), $this->postData)
            ->assertUnauthorized();
        $this->actingAs($this->user)
            ->postJson(route('posts.store'), $this->postData)
            ->assertForbidden();

        $this->assertDatabaseMissing('posts', $this->postData);
    }
}
