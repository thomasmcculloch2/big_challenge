<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Constants\SubmissionStatus;
use App\Models\Submission;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class FinishSubmissionController extends Controller
{
    public function __invoke(Submission $submission): JsonResponse
    {
        if (!Gate::allows('doctorBelongsToSubmission', $submission)) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        $submission->update([
            'status' => SubmissionStatus::DONE
        ]);
        return response()->json(['message' => 'Submission finished successfully'], 201);
    }
}
