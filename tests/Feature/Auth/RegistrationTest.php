<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function testRegisterUserSuccessfully()
    {
        $response = $this->postJson(route('user.register'), [
            'name' => 'tom', 'email' => 'tom@mail.com', 'password' => 'tom123', 'type' => 'doctor'
        ]);

        $response->assertSuccessful()
            ->assertJsonStructure([
                'user',
                'token'
            ]);

        $this->assertDatabaseHas('users', ['email' => 'tom@mail.com']);
    }
}
