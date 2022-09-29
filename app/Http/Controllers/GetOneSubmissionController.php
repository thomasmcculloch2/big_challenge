<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\OneSubmissionResource;
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
        return response()->json(OneSubmissionResource::make($submission), 201);
    }
}
