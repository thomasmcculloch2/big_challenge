<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class LoginController
{
    public function __invoke(LoginRequest $request): JsonResponse
    {
        $data =  $request->validated();

        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json(['message' => 'Invalid Credentials'], 401);
        }
        $token = $user->createToken('userToken')->plainTextToken;
        $response = [
            'message' => 'Login successful',
            'user' => UserResource::collection([$user]),
            'token' => $token
        ];

            return response()->json($response, 201);
    }
}
