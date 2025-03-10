<?php

use App\Models\User;
use App\Enum\RoleEnum;
use Laravel\Passport\Passport;

beforeEach(function () {
    $this->admin = User::factory()->create(['role' => RoleEnum::ADMIN->value]);
    $this->superAdmin = User::factory()->create(['role' => RoleEnum::SUPERADMIN->value]);
    $this->regularUser = User::factory()->create(['role' => RoleEnum::REGULAR->value]);
});

// Create dataset for privileged_users
// Admin and superadmin
// So i won't repeat to write the test foreach role
dataset('privileged_users', function () {
    return [
        'admin' => [fn () => User::factory()->create(['role' => RoleEnum::ADMIN->value])],
        'superadmin' => [fn () => User::factory()->create(['role' => RoleEnum::SUPERADMIN->value])],
    ];
});

// Create a sets of an email
dataset('emails', [
    'valid email' => ['user@example.com'],
    'another valid email' => ['admin@test.com'],
    'invalid email - no domain' => ['user@'],
    'invalid email - missing @' => ['usertest.com'],
    'invalid email - special chars' => ['user@exa*mple.com'],
]);

it('allows admin and super-admin to access user list', function ($user) {
    Passport::actingAs($user);

    $response = $this->getJson('/api/users');
    $response->assertStatus(200);
})->with('privileged_users');

it('denies regular user from accessing user list', function () {
    Passport::actingAs($this->regularUser);

    $response = $this->getJson('/api/users');
    $response->assertStatus(403);
});

it('allows admin and superadmin to create a new user', function (string $email ) {
    Passport::actingAs($this->admin);

    $userData = [
        'name' => 'Admin Tambahan',
        'email' => $email,
        'password' => 'Password1234!',
        'role' => RoleEnum::REGULAR->value,
    ];

    $response = $this->postJson('/api/users', $userData);

    // Validate the email
    if (filter_var($email, FILTER_VALIDATE_EMAIL)){
    $response->assertStatus(201)
        ->assertJsonPath('message', 'Success creating new user');
    }else {
    $response->assertStatus(422);
    }

})->with('emails');

it('validates user creation request', function () {
    Passport::actingAs($this->admin);
    $response = $this->postJson('/api/users', []);
    $response->assertStatus(422);
});

it('allows admin to view user detail', function () {
    Passport::actingAs($this->admin);

    $response = $this->getJson("/api/users/{$this->regularUser->id}");
    $response->assertStatus(200)
        ->assertJsonPath('message', 'Success get user detail');
});

it('allows admin to delete a user', function () {
    Passport::actingAs($this->admin);

    $userToDelete = User::factory()->create(['role' => RoleEnum::REGULAR->value]);

    $response = $this->deleteJson("/api/users/{$userToDelete->id}");

    $response->assertStatus(200)
        ->assertJsonPath('message', 'Success delete user');

    $this->assertSoftDeleted('users', ['id' => $userToDelete->id]);
});

it('prevents regular users from deleting other users', function () {
    Passport::actingAs($this->regularUser);

    $response = $this->deleteJson("/api/users/{$this->admin->id}");

    $response->assertStatus(403);
});
