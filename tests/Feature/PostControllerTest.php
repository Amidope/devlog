<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    private User $user;
    private Post $post;

    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->post = Post::factory()
            ->recycle($this->user)
            ->has(Comment::factory()->count(3))
            ->create();
    }

    public function testIndex(): void
    {
        $this->get(route('posts.index'))
            ->assertOk();
    }

    public function testStore(): void
    {
        $this->actingAs($this->user);
        $data = Post::factory()->make()->toArray();
        $response = $this->postJson(route('posts.store'), $data);
        $response->assertStatus(201);
        $this->assertDatabaseHas('posts', $data);
        // add json structure test
        // add auth failure
    }

    public function testShow(): void
    {
        $response = $this->getJson(route('posts.show', $this->post));
        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $data = Post::factory()->make()->toArray();
        $response = $this->patchJson(route('posts.update', $this->post), $data);
        $response->assertOk();

        $data['body'] = fake()->text();
        $response = $this->patchJson(route('posts.update', $this->post), $data);
        $response->assertOk();

    }

    public function testDelete(): void
    {
        $id = $this->post->id;
        $response = $this->deleteJson(route('posts.destroy', $this->post));
        $response->assertStatus(204);
        $this->assertDatabaseMissing('posts', ['id' => $id]);
    }

}
