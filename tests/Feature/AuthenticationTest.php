<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private string $password;

    protected function setUp(): void
    {
        parent::setUp();
        $this->password = Str::random();
        $this->user = User::factory()->create(['password' => $this->password]);
    }
    public function testUserCanAuthenticate()
    {
        $token = $this->user->createToken('auth_token')->plainTextToken;
        $data = $this->user->only('email');
        $data['password'] = $this->password;

        $response = $this->postJson(route('login'), $data);
        $response->assertOk();
        $response->assertJsonStructure([
            'access_token',
            'token_type',
        ]);
    }

    public function testUsersCanNotAuthenticateWithInvalidPassword()
    {
        $data = $this->user->only('email');
        $data['password'] = 'wrong_password';
        $response = $this->postJson(route('login'), $data);
        $response->assertUnauthorized();
    }

    public function testUserCanLogout()
    {
        $token = $this->user->createToken('test_token')->plainTextToken;
        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson(route('logout'));
        $response->assertOk();
        $this->user->refresh();
        $this->assertDatabaseMissing(
            'personal_access_tokens',
            [
                'tokenable_id' => $this->user->id,
                'name' => 'test_token'
            ]
        );
    }
}
