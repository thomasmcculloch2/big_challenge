<?php

namespace Tests\Feature;

use App\Models\Constants\Rol;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PatientInfoTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreatePatientInfo()
    {
        $user = User::factory()->patient()->create();
        $this->actingAs($user);

        $response = $this->postJson();

        $response->assertSuccessful()
            ->assertJsonStructure([
                'user',
                'token'
            ]);

        $this->assertDatabaseHas('users', ['email' => 'tom@mail.com']);
    }
}
