<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InformationTest extends TestCase
{
    use RefreshDatabase;

    public function testCreatePatientInfo(): void
    {
        $user = User::factory()->patient()->create();
        $this->actingAs($user);

        $response = $this->postJson(route('patient.info'), [
            'phone' => '098456377', 'weight' => '79', 'height' => '188', 'info' => 'Problems you might have'
        ])->assertSuccessful();

        $this->assertDatabaseHas('information', ['patient_id' => $user->id]);
    }

    public function testCreatePatientInfoAsDoctor(): void
    {
        $user = User::factory()->doctor()->create();
        $this->actingAs($user);

        $response = $this->postJson(route('patient.info'), [
            'phone' => '098456377', 'weight' => '79', 'height' => '188', 'info' => 'Problems you might have'
        ])->assertForbidden();
    }

    public function testCreatePatientInfoWithoutPhone(): void
    {
        $user = User::factory()->patient()->create();
        $this->actingAs($user);

        $response = $this->postJson(route('patient.info'), [
            'weight' => '79', 'height' => '188', 'info' => 'Problems you might have'
        ])->assertUnprocessable();
    }

    public function testCreatePatientInfoWithoutWeight(): void
    {
        $user = User::factory()->patient()->create();
        $this->actingAs($user);

        $response = $this->postJson(route('patient.info'), [
            'phone' => '098456377', 'height' => '188', 'info' => 'Problems you might have'
        ])->assertUnprocessable();
    }

    public function testCreatePatientInfoWithoutHeight(): void
    {
        $user = User::factory()->patient()->create();
        $this->actingAs($user);

        $response = $this->postJson(route('patient.info'), [
            'phone' => '098456377', 'weight' => '79', 'info' => 'Problems you might have'
        ])->assertUnprocessable();
    }

    public function testCreatePatientInfoWithoutInfo(): void
    {
        $user = User::factory()->patient()->create();
        $this->actingAs($user);

        $response = $this->postJson(route('patient.info'), [
            'phone' => '098456377', 'weight' => '79', 'height' => '188'
        ])->assertUnprocessable();
    }
}
