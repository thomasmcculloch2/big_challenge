<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AssignDoctorController extends Controller
{
    public function __invoke(Submission $submission): JsonResponse
    {
        $user = Auth::user();
        if ($submission->doctor != NULL) {
            return response()->json(['message' => 'Submission already have a doctor'], 401);
        }
        $submission->doctor_id = $user->id;
        $submission->save();
        return response()->json(['message' => 'Doctor associated successfully'], 201);
    }
}
