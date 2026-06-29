<?php

namespace App\Http\Controllers\Api;

use App\Actions\LoginUserAction;
use App\Actions\RegisterUserAction;
use App\DTOs\LoginDTO;
use App\DTOs\RegisterDTO;
use App\Http\Controllers\ApiController;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends ApiController
{
    /**
     * Handle user registration.
     */
    public function register(RegisterRequest $request, RegisterUserAction $action): JsonResponse
    {
        $dto = RegisterDTO::fromArray($request->validated());
        $user = $action->execute($dto);

        return $this->successResponse(
            new UserResource($user),
            'User registered successfully.',
            201
        );
    }

    /**
     * Handle user login.
     */
    public function login(LoginRequest $request, LoginUserAction $action): JsonResponse
    {
        $dto = LoginDTO::fromArray($request->validated());
        $result = $action->execute($dto);

        return $this->successResponse([
            'user' => new UserResource($result['user']),
            'token' => $result['token'],
        ], 'User logged in successfully.');
    }

    /**
     * Handle user logout.
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return $this->successResponse(null, 'User logged out successfully.');
    }

    /**
     * Get the authenticated user's profile.
     */
    public function profile(Request $request): JsonResponse
    {
        return $this->successResponse(
            new UserResource($request->user()),
            'User profile retrieved successfully.'
        );
    }
}
