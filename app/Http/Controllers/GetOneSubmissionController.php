<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\OneSubmissionResource;
use App\Http\Resources\SubmissionResource;
use App\Models\Constants\Rol;
use App\Models\Submission;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class GetOneSubmissionController
{
    public function __invoke($id): JsonResponse
    {

            $submission = Submission::find($id);
            return response()->json(OneSubmissionResource::make($submission), 201);
    }
}
