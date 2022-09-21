<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function loginIsSuccess(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson(route('user.login'), [
            'email' => $user->email,
            'password' => $user->password
        ]);

        $response->assertSuccessful()
            ->assertJsonStructure([
                'user',
                'token'
            ]);
    }

    public function loginWithInvalidEmailOrPassword(): void
    {
        $this->postJson(route('user.login'), [
            'email' => 'invalid@mail.com',
            'password' => 'password'
        ])->assertUnauthorized();
    }

    public function loginWithoutEmail(): void
    {
        $this->postJson(route('user.login'), [
            'email' => '',
            'password' => 'password'
        ])->assertUnprocessable();
    }

    public function loginWithoutPassword(): void
    {
        $this->postJson(route('user.login'), [
            'email' => 'mail@mail.com',
            'password' => ''
        ])->assertUnprocessable();
    }

    public function loginWithoutValidEmail(): void
    {
        $this->postJson(route('user.login'), [
            'email' => 'mail',
            'password' => 'password'
        ])->assertUnprocessable();
    }
}
