<?php

namespace Tests\Feature\Submissions;

use App\Models\PatientsInfos;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function testNewSubmissionSuccessful(): void
    {
        $user = User::factory()->patient()->create();
        $this->actingAs($user);
        PatientsInfos::factory()->create([
            'patient_id' => $user->id,
        ]);

        $response = $this->postJson(route('submission.new'), [
            'title' => 'Gripe', 'symptoms' => 'Dolor de cabeza, mareos, nauseas, etc'
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('submissions', ['title' => 'Gripe']);
    }

    public function testNewSubmissionWithoutToken(): void
    {
        $user = User::factory()->create();
        $response = $this->postJson(route('submission.new'), [
            'title' => 'Gripe', 'symptoms' => 'Dolor de cabeza, mareos, nauseas, etc'
        ]);
        $response->assertUnauthorized();
    }

    public function testNewSubmissionWithoutTitle(): void
    {
        $user = User::factory()->patient()->create();
        $this->actingAs($user);
        PatientsInfos::factory()->create([
            'patient_id' => $user->id,
        ]);

        $response = $this->postJson(route('submission.new'), [
            'symptoms' => 'Dolor de cabeza, mareos, nauseas, etc'
        ]);

        $response->assertUnprocessable();
    }

    public function testNewSubmissionWithoutSymptoms(): void
    {
        $user = User::factory()->patient()->create();
        $this->actingAs($user);
        PatientsInfos::factory()->create([
            'patient_id' => $user->id,
        ]);

        $response = $this->postJson(route('submission.new'), [
            'title' => 'Gripe'
        ]);

        $response->assertUnprocessable();
    }

    public function testNewSubmissionBeingADoctor(): void
    {
        $user = User::factory()->doctor()->create();
        $this->actingAs($user);

        $response = $this->postJson(route('submission.new'), [
            'title' => 'Gripe',
            'symptoms' => 'Dolor de cabeza, mareos, nauseas, etc'
        ]);

        $response->assertForbidden();
    }
}
