<?php

namespace Tests\Feature\Auth;

use App\Models\Constants\Rol;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function testRegisterDoctorSuccessfully()
    {
        Role::create(['name' => Rol::ROL['DOCTOR']]);
        Role::create(['name' => Rol::ROL['PATIENT']]);
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

    public function testRegisterPatientSuccessfully()
    {
        Role::create(['name' => Rol::ROL['DOCTOR']]);
        Role::create(['name' => Rol::ROL['PATIENT']]);
        $response = $this->postJson(route('user.register'), [
            'name' => 'tom', 'email' => 'tom@mail.com', 'password' => 'tom123', 'type' => 'patient'
        ]);

        $response->assertSuccessful()
            ->assertJsonStructure([
                'user',
                'token'
            ]);

        $this->assertDatabaseHas('users', ['email' => 'tom@mail.com']);
    }

    public function testRegisterUserWithoutName()
    {
        $response = $this->postJson(route('user.register'), [
            'email' => 'tom@mail.com', 'password' => 'tom123', 'type' => 'doctor'
        ])->assertUnprocessable();
    }

    public function testRegisterUserWithoutEmail()
    {
        $response = $this->postJson(route('user.register'), [
            'name' => 'tom', 'password' => 'tom123', 'type' => 'doctor'
        ])->assertUnprocessable();
    }

    public function testRegisterUserWithoutPassword()
    {
        $response = $this->postJson(route('user.register'), [
            'name' => 'tom', 'email' => 'tom@mail.com', 'type' => 'doctor'
        ])->assertUnprocessable();
    }

    public function testRegisterUserWithoutType()
    {
        $response = $this->postJson(route('user.register'), [
            'name' => 'tom', 'email' => 'tom@mail.com', 'password' => 'tom123'
        ])->assertUnprocessable();
    }

    public function testRegisterUserWithInvalidType()
    {
        $response = $this->postJson(route('user.register'), [
            'name' => 'tom', 'email' => 'tom@mail.com', 'password' => 'tom123', 'type' => 'invalid'
        ])->assertUnprocessable();
    }

    public function testRegisterUserWithInvalidEmail()
    {
        $response = $this->postJson(route('user.register'), [
            'name' => 'tom', 'email' => 'tommail.com', 'password' => 'tom123', 'type' => 'patient'
        ])->assertUnprocessable();
    }
}
