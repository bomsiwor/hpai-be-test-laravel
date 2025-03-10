<?php

use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Passport;

beforeEach(function () {
    Artisan::call('passport:client', ['--personal' => true, '--name' => 'BE HPAI']);
    $this->user = User::factory()->create([
        'email' => 'admin@mail.com',
    ]);
});

it('logs in a user with correct credentials', function () {
    $response = $this->postJson('/api/auth/login', [
        'email' => 'admin@mail.com',
        'password' => 'Password123!',
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure(['message', 'data' => ['accessToken', 'user']]);
});

it('fails login with wrong credentials', function () {
    $response = $this->postJson('/api/auth/login', [
        'email' => 'test@example.com',
        'password' => 'Passwrd1234!',
    ]);

    $response->assertStatus(401)
        ->assertJson(['message' => 'Failed to login, username or email and password does not match']);
});

it('returns authenticated user', function () {
    Passport::actingAs($this->user);

    $response = $this->getJson('/api/auth/me');

    $response->assertStatus(200)
        ->assertJson(['data' => ['email' => 'admin@mail.com']]);
});

