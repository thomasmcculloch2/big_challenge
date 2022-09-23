<?php

namespace Tests\Feature\Submissions;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Factories\Sequence;

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
                ['patient' => $user->id],
                ['patient' => User::factory()],
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

        $response = $this->getJson(route('submission.index'))->assertSuccessful();
    }

    public function testGetSubmissionNotLogged(): void
    {
        $response = $this->getJson(route('submission.index'))->assertUnauthorized();
    }
}
