<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct(protected User $user)
    {
    }

    public function login(LoginRequest $request)
    {
        try {
            if (!Auth::attempt($request->validated())) {
                throw new \Exception('Failed to login, username or email and password does not match');
            }

            // Generate token
            $user = Auth::user();

            return $this->successResponse('Success Login', [
                'accessToken' => $user->createToken('Login')->accessToken,
                'user' => new UserResource($user),
            ]);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), code: 401);
        }
    }

    public function me()
    {
        return new UserResource(auth()->guard('api')->user());
    }

    public function refreshToken()
    {
    }

    public function logout()
    {
        try {
            $isRevoked = auth()->guard('api')->user()->token()->revoke();

            if (!$isRevoked) {
                throw new \Exception('Cannot logout.');
            }

            return $this->successResponse('Succesfully logout');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 500);
        }
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        try {
            // Change user password
            Auth::user()->update([
                'password' => Hash::make($request->validated('newPassword')['new_password']),
            ]);

            return $this->successResponse('Success update password');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 500);
        }
    }

    public function update(UpdateProfileRequest $request)
    {
        try {
            // Change user password
            Auth::user()->update([
                ...$request->validated(),
            ]);

            return $this->successResponse('Success update profile');
        } catch (\Throwable $th) {
            return $this->errorResponse('Error update profile', 500);
        }
    }
}
