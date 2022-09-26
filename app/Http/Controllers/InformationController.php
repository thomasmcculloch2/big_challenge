<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\PatientInfoRequest;
use App\Http\Resources\PatientInfoResource;
use App\Models\Information;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class InformationController extends Controller
{
    public function __invoke(PatientInfoRequest $request): JsonResponse
    {
        $data = $request->validated();
        /* @var User $user */
        $user = $request->user();

        $patient = Information::where('patient_id', $user->id)->first();
        if (!$patient) {
            $patientInfo = Information::create([
                'phone' => $data['phone'],
                'weight' => $data['weight'] ,
                'height' => $data['height'],
                'info' => $data['info'],
                'patient_id' => $user->id
            ]);

            $response = [
                'message' => 'Patient info created successfully',
                'info' => PatientInfoResource::make($patientInfo),
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
