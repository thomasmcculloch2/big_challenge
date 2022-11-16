<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\SubmissionResource;
use App\Models\Submission;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class GetOneSubmissionController
{
    public function __invoke(Submission $submission): JsonResponse
    {
        if (!Gate::allows('canGetOneSubmission', $submission)) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        return response()->json(SubmissionResource::make($submission), 201);
    }
}
