<?php

namespace Tests\Feature;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DownloadAttachmentTest extends TestCase
{
    use RefreshDatabase;

    public function testDownloadAttachmentSuccessfullyBeingADoctor(): void
    {
        $submission = Submission::factory()->withDoctor()->create();
        $this->actingAs($submission->doctor);

        Storage::fake();

        $this->postJson(route('submission.upload', "$submission->id"), [
            'uploadedFile' => UploadedFile::fake()->create('text.txt')
        ]);
        $submission->refresh();

        $this->postJson(route('submission.download', "$submission->id"))->assertSuccessful();
    }

    public function testDownloadAttachmentUnsuccessfullyBeingADoctor(): void
    {
        $user = User::factory()->doctor()->create();
        $submission = Submission::factory()->withDoctor()->create();
        $this->actingAs($submission->doctor);

        Storage::fake();

        $this->postJson(route('submission.upload', "$submission->id"), [
            'uploadedFile' => UploadedFile::fake()->create('text.txt')
        ]);
        $submission->refresh();

        $this->actingAs($user);
        $this->postJson(route('submission.download', "$submission->id"))->assertForbidden();
    }

    public function testDownloadAttachmentSuccessfullyBeingAPatient(): void
    {
        $submission = Submission::factory()->withDoctor()->create();
        $this->actingAs($submission->doctor);

        Storage::fake();

        $this->postJson(route('submission.upload', "$submission->id"), [
            'uploadedFile' => UploadedFile::fake()->create('text.txt')
        ]);

        $submission->refresh();
        $this->actingAs($submission->patient);

        $this->postJson(route('submission.download', "$submission->id"))->assertSuccessful();
    }

    public function testDownloadAttachmentUnsuccessfullyBeingAPatient(): void
    {
        $submission = Submission::factory()->withDoctor()->create();
        $this->actingAs($submission->doctor);

        Storage::fake();

        $this->postJson(route('submission.upload', "$submission->id"), [
            'uploadedFile' => UploadedFile::fake()->create('text.txt')
        ]);

        $submission->refresh();
        $this->actingAs(User::factory()->patient()->create());

        $this->postJson(route('submission.download', "$submission->id"))->assertForbidden();
    }
}
