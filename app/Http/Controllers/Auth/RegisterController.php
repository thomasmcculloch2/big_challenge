<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\Constant;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class RegisterController
{
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();
        if ($data['type'] != Constant::USER_TYPE['DOCTOR'] && $data['type'] != Constant::USER_TYPE['PATIENT']) {
            return response()->json(['message' => 'Must give a valid type'], 422);
        }
        $user =  User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        if ($data['type'] == Constant::USER_TYPE['DOCTOR']) {
            $user->assignRole('doctor');
        } else {
            $user->assignRole('patient');
        }

        $token = $user->createToken('userToken')->plainTextToken;

        $response = [
            'message' => 'User created successfully',
            'user' => UserResource::collection([$user]),
            'token' => $token
        ];

        return response()->json($response, 201);
    }
}
