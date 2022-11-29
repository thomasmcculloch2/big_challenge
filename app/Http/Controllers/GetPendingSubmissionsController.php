<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\SubmissionResource;
use App\Models\Constants\Rol;
use App\Models\Constants\SubmissionStatus;
use App\Models\Submission;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class GetPendingSubmissionsController
{
    public function __invoke(): JsonResponse
    {
        $submissions = Submission::query()->where('status', SubmissionStatus::PENDING)->paginate();
        return response()->json(SubmissionResource::collection($submissions));
    }
}
