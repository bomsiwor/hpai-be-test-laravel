<?php

namespace App\Services;

use App\Enum\RoleEnum;
use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\User;
use Exception;

class UserService
{
    public function __construct(protected User $model) {}

    public function getList()
    {
        // Get all user data
        $result = $this->model->with('roles')->get();

        return $result;
    }

    public function store(UserRequest $request)
    {
        // I am not using transaction or try catch block
        // Because this is only operated on 1 table.
        $data = $request->validated();

        // There will be only one super admin
        $superadmin = Role::where('name', RoleEnum::SUPERADMIN->value)->first();

        // If logged in user has superadmin, dont omit role
        // Otherwise omit id from request
        $superadmin = [$superadmin->id];

        $rolesId = array_diff( $data['roles'], $superadmin);

        // Store using model
        $user = $this->model->create($data);

        $user->roles()->sync($rolesId);

        // Return user to controller
        return $user;
    }

    public function delete(User $model)
    {
        // User can't delete their own account
        if ($model->id == auth()->guard()->id()) {
            throw new Exception("You can't delete your account");
        }

        // Super admin can't be deleted
        if ($model->role == RoleEnum::SUPERADMIN->value) {
            throw new Exception("You can't delete your account");
        }

        $model->delete();
    }
}
