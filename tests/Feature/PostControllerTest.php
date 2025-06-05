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
        $user = User::factory();
        $this->actingAs($this->user);
        $data = Post::factory()->make()->toArray();
//        dd($data);
        $response = $this->postJson(route('posts.store'), $data);
        $response->assertStatus(Response::HTTP_CREATED);
        // add json structure test
        // add auth failure
    }

    public function testShow(): void
    {
//        $response = $this->getJson()
    }

    public function testUpdate(): void
    {

    }

    public function testDelete(): void
    {

    }

}
