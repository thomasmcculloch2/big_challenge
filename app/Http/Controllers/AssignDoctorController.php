<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Constants\SubmissionStatus;
use App\Models\Submission;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AssignDoctorController
{
    public function __invoke(Submission $submission): JsonResponse
    {
        if ($submission->doctor) {
            return response()->json(['message' => 'Submission already have a doctor'], 401);
        }
        $submission->update([
            'doctor_id' => Auth::id(),
            'status' => SubmissionStatus::IN_PROGRESS
        ]);
        return response()->json(['message' => 'Doctor associated successfully'], 201);
    }
}
