<?php

namespace Tests\Feature;

use App\Models\Constants\Rol;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PatientInfoTest extends TestCase
{
    use RefreshDatabase;

    public function testCreatePatientInfo(): void
    {
        $user = User::factory()->patient()->create();
        $this->actingAs($user);
        Role::create(['name' => Rol::FULL_PATIENT]);

        $response = $this->postJson(route('patient.info'), [
            'phone' => '098456377', 'weight' => '79', 'height' => '188', 'info' => 'Problems you might have'
        ])->assertSuccessful();

        $this->assertDatabaseHas('patients_infos', ['patient_id' => $user->id]);
    }

    public function testCreatePatientInfoAsDoctor(): void
    {
        $user = User::factory()->doctor()->create();
        $this->actingAs($user);

        $response = $this->postJson(route('patient.info'), [
            'phone' => '098456377', 'weight' => '79', 'height' => '188', 'info' => 'Problems you might have'
        ])->assertForbidden();
    }

    public function testCreatePatientInfoWithouPhone(): void
    {
        $user = User::factory()->patient()->create();
        $this->actingAs($user);

        $response = $this->postJson(route('patient.info'), [
            'weight' => '79', 'height' => '188', 'info' => 'Problems you might have'
        ])->assertUnprocessable();
    }

    public function testCreatePatientInfoWithouWeiht(): void
    {
        $user = User::factory()->patient()->create();
        $this->actingAs($user);

        $response = $this->postJson(route('patient.info'), [
            'phone' => '098456377', 'height' => '188', 'info' => 'Problems you might have'
        ])->assertUnprocessable();
    }

    public function testCreatePatientInfoWithouHeight(): void
    {
        $user = User::factory()->patient()->create();
        $this->actingAs($user);

        $response = $this->postJson(route('patient.info'), [
            'phone' => '098456377', 'weight' => '79', 'info' => 'Problems you might have'
        ])->assertUnprocessable();
    }

    public function testCreatePatientInfoWithouInfo(): void
    {
        $user = User::factory()->patient()->create();
        $this->actingAs($user);

        $response = $this->postJson(route('patient.info'), [
            'phone' => '098456377', 'weight' => '79', 'height' => '188'
        ])->assertUnprocessable();
    }
}
