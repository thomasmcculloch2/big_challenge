<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\PatientInfoRequest;
use App\Http\Requests\SubmissionRequest;
use App\Http\Resources\PatientInfoResource;
use App\Http\Resources\SubmissionResource;
use App\Models\Constants\Rol;
use App\Models\Constants\SubmissionStatus;
use App\Models\PatientsInfos;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Spatie\Permission\Models\Role;

class PatientInfoController extends Controller
{
    public function __invoke(PatientInfoRequest $request): JsonResponse
    {
        $data = $request->validated();
        /* @var User $user */
        $user = auth()->user();

        $patient = PatientsInfos::where('patient_id', $user->id)->first();
        if (!$patient) {
            $user->assignRole(Rol::FULL_PATIENT);

            $patient_info = PatientsInfos::create([
                'phone' => $data['phone'],
                'weight' => $data['weight'] ,
                'height' => $data['height'],
                'info' => $data['info'],
                'patient_id' => $user->id
            ]);

            $response = [
                'message' => 'Patient info created successfully',
                'info' => PatientInfoResource::make($patient_info),
            ];

            return response()->json($response, 201);
        }
        $patient->update([
            'phone' => $data['phone'],
            'weight' => $data['weight'] ,
            'height' => $data['height'],
            'info' => $data['info'],
        ]);

        $response = [
            'message' => 'Patient info updated successfully',
            'info' => PatientInfoResource::make($patient),
        ];

        return response()->json($response, 201);
    }
}
