<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Http;

class AuthControllerTest extends TestCase
{
    /** @test */
    public function login_via_supabase_success()
    {
        // Mock Supabase Auth response
        Http::fake([
            env('SUPABASE_URL') . '/auth/v1/token?grant_type=password' => Http::response([
                'access_token' => 'mock-access-token',
                'user' => ['id' => 'user-id', 'email' => 'ikhsann330@gmail.com']
            ], 200),
            env('SUPABASE_URL') . '/rest/v1/users*' => Http::response([
                ['role' => 'karyawan']
            ], 200),
        ]);

        $response = $this->postJson('/api/login-v2', [
            'email' => 'ikhsann330@gmail.com',
            'password' => 'ikhsann330@gmail.com'
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'Login berhasil',
                     'access_token' => 'mock-access-token',
                     'role' => 'karyawan',
                 ]);
    }

    /** @test */
    public function login_via_supabase_invalid_credentials()
    {
        // Mock Supabase Auth failure
        Http::fake([
            env('SUPABASE_URL') . '/auth/v1/token?grant_type=password' => Http::response([
                'error' => 'Invalid login',
                'error_description' => 'Invalid email or password'
            ], 401),
        ]);

        $response = $this->postJson('/api/login-v2', [
            'email' => 'wrong@gmail.com',
            'password' => 'wrongpassword'
        ]);

        $response->assertStatus(401)
                 ->assertJson([
                     'message' => 'Invalid email or password',
                 ]);
    }
}
