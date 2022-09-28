<?php

namespace Tests\Feature\Submissions;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function testGetSubmissionSuccessfulAsPatient(): void
    {
        $user = User::factory()->patient()->create();
        $this->actingAs($user);

        $submission = Submission::factory()
            ->count(10)
            ->state(new Sequence(
                ['patient_id' => $user->id],
                ['patient_id' => User::factory()->patient()->create()],
            ))
            ->create();

        $response = $this->getJson(route('submission.index'));
        $response->assertSuccessful()
            ->assertJsonCount(5);
    }

    public function testGetSubmissionSuccessfulAsDoctor(): void
    {
        $user = User::factory()->doctor()->create();
        $this->actingAs($user);

        $submission = Submission::factory()
            ->count(10)
            ->state(new Sequence(
                ['patient_id' => User::factory()->patient()->create()],
                ['patient_id' => User::factory()->patient()->create()],
            ))
            ->create();

        $response = $this->getJson(route('submission.index'));
        $response->assertSuccessful()
            ->assertJsonCount(10);
    }

    public function testGetSubmissionNotLogged(): void
    {
        $response = $this->getJson(route('submission.index'))->assertUnauthorized();
    }
}
