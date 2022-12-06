<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\SubmissionResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class GetMySubmissionsController
{
    public function __invoke(): JsonResponse
    {
        $user = Auth::user();
        $submissions = $user->submissions;
        return response()->json(SubmissionResource::collection($submissions));
    }
}
