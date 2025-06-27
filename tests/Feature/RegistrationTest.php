<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function testNewUserCanRegister(): void
    {
        $user = User::factory()->make()->only('name', 'email');
        $password = Str::random(30);
        $data = [
            ...$user,
            'password' => $password,
            'password_confirmation' => $password,
        ];
        $response = $this->postJson(route('register'), $data);
        $response->assertCreated();
        $this->assertDatabaseHas('users', $user);
    }
}
