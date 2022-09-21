<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function testLoginIsSuccess(): void
    {
        $user = User::factory()->create();

        $user =  User::create([
            'name' => 'tommy',
            'email' => 'tommy@mail.com',
            'password' => Hash::make('password'),
            'type' => 'doctor',
        ]);

        $response = $this->postJson(route('user.login'), [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertSuccessful()
            ->assertJsonStructure([
                'user',
                'token'
            ]);
    }

    public function testLoginWithInvalidEmailOrPassword(): void
    {
        $this->postJson(route('user.login'), [
            'email' => 'invalid@mail.com',
            'password' => 'password'
        ])->assertUnauthorized();
    }

    public function testLoginWithoutEmail(): void
    {
        $this->postJson(route('user.login'), [
            'email' => '',
            'password' => 'password'
        ])->assertUnprocessable();
    }

    public function testLoginWithoutPassword(): void
    {
        $this->postJson(route('user.login'), [
            'email' => 'mail@mail.com',
            'password' => ''
        ])->assertUnprocessable();
    }

    public function testLoginWithoutValidEmail(): void
    {
        $this->postJson(route('user.login'), [
            'email' => 'mail',
            'password' => 'password'
        ])->assertUnprocessable();
    }
}
