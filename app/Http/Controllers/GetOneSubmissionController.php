<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\OneSubmissionResource;
use App\Models\Submission;
use Illuminate\Http\JsonResponse;

class GetOneSubmissionController
{
    public function __invoke(int $id): JsonResponse
    {
            $submission = Submission::find($id);
            return response()->json(OneSubmissionResource::make($submission), 201);
    }
}
