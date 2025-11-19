<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardCTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test user yang belum login tidak bisa akses dashboard
     */
    public function test_dashboard_memerlukan_autentikasi()
    {
        $response = $this->get(route('admin.dashboard'));

        // Assert redirect ke login
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Test user yang sudah login bisa akses dashboard
     */
    public function test_user_login_dapat_akses_dashboard()
    {
        // Buat user
        $user = User::factory()->create();

        // Login
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password', // Default password dari factory
        ]);

        // Setelah login, coba akses dashboard
        $response = $this->get(route('admin.dashboard'));

        // Assert bukan redirect (bukan 302)
        $this->assertNotEquals(302, $response->status());
    }

    /**
     * Test route dashboard ada
     */
    public function test_route_dashboard_terdaftar()
    {
        // Cek apakah route admin.dashboard ada
        $this->assertTrue(
            \Illuminate\Support\Facades\Route::has('admin.dashboard'),
            'Route admin.dashboard tidak ditemukan'
        );
    }

}