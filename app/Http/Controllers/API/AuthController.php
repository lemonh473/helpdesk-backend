<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Services\UserService;
use App\Models\User;
use JWTAuth;

class AuthController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }
    
    public function register(RegisterRequest $request)
    {
        $payload = $request->validated();

        $this->service->create($payload);

        $token = auth()->guard()->attempt([
            'email' => $payload['email'],
            'password' => $payload['password']
        ]);

        if ($token) {
            return $this->respondWithToken(auth()->refresh());
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    public function login(LoginRequest $request)
    {
        $payload = $request->only('email', 'password');
        $token = auth()->guard()->attempt($payload);

        if ($token) {
            return $this->respondWithToken(auth()->refresh());
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json([
            'status' => 'success',
            'message' => 'Logged out!'
        ], 200);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }
    
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'email' => auth()->user()->email,
            'role' => auth()->user()->userRole->role ?? 2
        ]);
    }
}
