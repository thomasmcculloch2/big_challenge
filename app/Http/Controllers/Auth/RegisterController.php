<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class RegisterController
{
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user =  User::create([
            'name'=> $data['name'],
            'email'=> $data['email'],
            'password'=> Hash::make($data['password']),
            'type'=> $data['type'],
        ]);

        $token = $user->createToken('userToken')->plainTextToken;

        $response = [
            'message' => 'User created successfully',
            'user' => $user,
            'token' => $token
        ];

        return response()->json($response, 201);
    }
}
