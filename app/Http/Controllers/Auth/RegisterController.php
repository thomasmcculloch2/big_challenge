<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\Constants\Rol;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Events\Dispatcher;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class RegisterController
{
    private Dispatcher $dispatcher;

    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();
        if ($data['type'] != Rol::DOCTOR && $data['type'] != Rol::PATIENT) {
            return response()->json(['message' => 'Must give a valid type'], 422);
        }
        $user =  User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        if ($data['type'] == Rol::DOCTOR) {
            $user->assignRole(Rol::DOCTOR);
        } else {
            $user->assignRole(Rol::PATIENT);
        }

        $token = $user->createToken('userToken')->plainTextToken;
        $this->dispatcher->dispatch(new Registered($user));
        $response = [
            'message' => 'User created successfully',
            'user' => UserResource::make($user),
            'token' => $token
        ];

        return response()->json($response, 201);
    }
}
