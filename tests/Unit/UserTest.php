<?php

use App\Models\User;
use App\Services\UserService;
use App\Http\Requests\UserRequest;
use App\Enum\RoleEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Start to create initialize data using factory
    $this->user = User::factory()->create();
    $this->service = new UserService(new User());
});

it('can retrieve user list', function () {
    User::factory()->count(3)->create();

    $users = $this->service->getList();

    expect($users)->toHaveCount(4);
});

it('can store a user', function () {
    // Create dummy data of user
    $data = [
        'name' => 'Admin 2',
        'email' => 'admin2@mail.com',
        'password' => bcrypt('password'),
        'role' => RoleEnum::REGULAR->value
    ];

    // Mock request data
    $request = Mockery::mock(UserRequest::class);
    $request->shouldReceive('validated')->andReturn($data);

    $user = $this->service->store($request);

    expect($user)->toBeInstanceOf(User::class)
        ->and($user->email)->toBe('admin2@mail.com')
        ->and($user->role)->toBe(RoleEnum::REGULAR->value);
});

it('prevents a user from deleting their own account', function () {
    // Beacuse auth is used to compare the super admin acount
    Auth::shouldReceive('guard->id')->andReturn($this->user->id);

    $this->service->delete($this->user);
})->throws(Exception::class, "You can't delete your account");

it('prevents super admin from being deleted', function () {
    $superAdmin = User::factory()->create(['role' => RoleEnum::SUPERADMIN->value]);

    $this->service->delete($superAdmin);
})->throws(Exception::class, "You can't delete your account");

it('deletes a regular user', function () {
    $anotherUser = User::factory()->create(['role' => RoleEnum::REGULAR->value]);

    $this->service->delete($anotherUser);

    expect(User::find($anotherUser->id))->toBeNull();
});

it('deletes an admin user', function () {
    $anotherUser = User::factory()->create(['role' => RoleEnum::ADMIN->value]);

    $this->service->delete($anotherUser);

    expect(User::find($anotherUser->id))->toBeNull();
});
