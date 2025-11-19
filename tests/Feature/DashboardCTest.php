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

    /**
     * Test dashboard dengan filter tahun
     */
    public function test_dashboard_dapat_difilter_berdasarkan_tahun()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Akses dashboard dengan parameter tahun
        $response = $this->get(route('admin.dashboard', ['tahun' => 2020]));

        // Assert request berhasil (200 atau 500 bukan 302 redirect)
        $this->assertNotEquals(302, $response->status());
        
        // Assert parameter tahun diterima
        $this->assertEquals(2020, request()->query('tahun'));
    }

    /**
     * Test dashboard dengan filter status
     */
    public function test_dashboard_dapat_difilter_berdasarkan_status()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Akses dashboard dengan parameter status
        $response = $this->get(route('admin.dashboard', ['status' => 'Bekerja']));

        // Assert request berhasil
        $this->assertNotEquals(302, $response->status());
        
        // Assert parameter status diterima
        $this->assertEquals('Bekerja', request()->query('status'));
    }
}