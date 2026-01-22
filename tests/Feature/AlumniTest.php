<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Alumni;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AlumniTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test untuk memvalidasi syarat Kelompok 5: Large Dataset Handling.
     * @test
     */
    public function system_can_handle_large_dataset_seeding()
    {
        // Menjalankan seeder alumni
        $this->seed(\Database\Seeders\AlumniSeeder::class);

        // Memastikan jumlah data mencapai minimal 1000 records
        $count = Alumni::count();
        $this->assertGreaterThanOrEqual(1000, $count);
    }

    /**
     * Test akses halaman utama tracer alumni.
     * @test
     */
    public function alumni_page_is_accessible()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
}