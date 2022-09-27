<?php

namespace Tests\Feature;

use App\Models\Submission;
use App\Models\User;
use Tests\TestCase;

class AssignDoctorTest extends TestCase
{
    public function testAssignDoctorToSubmissionSuccessful(): void
    {
        $user = User::factory()->doctor()->create();
        $this->actingAs($user);

        $submission = Submission::factory()->create();

        $response = $this->postJson(route('doctor.assign', "$submission->id"));
        $response->assertSuccessful();
    }

    public function testAssignDoctorToSubmissionFail(): void
    {
        $user = User::factory()->doctor()->create();
        $this->actingAs($user);

        $submission = Submission::factory()->withDoctor()->create();

        $response = $this->postJson(route('doctor.assign', "$submission->id"));
        $response->assertUnauthorized();
    }

    public function testAssignDoctorToSubmissionBeingAPatient(): void
    {
        $user = User::factory()->patient()->create();
        $this->actingAs($user);

        $submission = Submission::factory()->create();

        $response = $this->postJson(route('doctor.assign', "$submission->id"));
        $response->assertForbidden();
    }
}
