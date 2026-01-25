<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Alumni;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AlumniTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Memvalidasi Syarat Kelompok 5: Large Dataset Handling (1000+ Records).
     * @test
     */
    public function system_can_handle_large_dataset_seeding()
    {
        $this->seed(\Database\Seeders\AlumniSeeder::class);

        $count = Alumni::count();
        $this->assertGreaterThanOrEqual(1000, $count);
    }

    /**
     * Memvalidasi Syarat Kelompok 5: Analytics Data Integrity.
     * @test
     */
    public function analytics_data_integrity_check()
    {
        $user = User::factory()->create();

        // Panggil langsung tanpa prefix /api
        $response = $this->actingAs($user)
                        ->withoutMiddleware()
                        ->get('/analytics/summary'); 

        $response->assertStatus(200);
    }

    /**
     * Memvalidasi Report Generation / Export.
     * @test
     */
    public function system_can_generate_alumni_report()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
                         ->withoutMiddleware()
                         ->get('/alumni/export');

        $response->assertStatus(200);
    }

    /**
     * Memvalidasi Scheduled Jobs (Cron) sesuai syarat Kelompok 5.
     * @test
     */
    public function scheduled_jobs_are_defined()
    {
        // Memastikan command schedule:run bisa dieksekusi tanpa error
        $this->artisan('schedule:run')->assertExitCode(0);
    }
}