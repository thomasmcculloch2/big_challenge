<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLoggedOutSuccessfully(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $token = auth()->user()->currentAccessToken();

        $response = $this->postJson(route('user.logout'), $headers = [
            'bearer' => $token,
        ]);

        $response->assertSuccessful();
    }
}
