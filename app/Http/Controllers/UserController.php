<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(protected UserService $service) {}

    public function index(Request $request)
    {
        $result = $this->service->getList();

        return $this->successResponse('Success get user list', UserResource::collection($result));
    }

    public function store(UserRequest $request)
    {
        // Use try catch here
        try {
            $result = $this->service->store($request);

            return $this->successResponse('Success creating new user', new UserResource($result), 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function show(User $model)
    {
        return $this->successResponse('Success get user detail', new UserResource($model));
    }

    public function destroy(User $model)
    {
        // Use try catch here
        try {
            $this->service->delete($model);

            return $this->successResponse('Success delete user', code: 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
