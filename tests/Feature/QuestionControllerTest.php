<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\JenisPertanyaan;
use App\Models\HalamanKuesioner;
use Illuminate\Foundation\Testing\RefreshDatabase;


class QuestionControllerTest extends TestCase
{
    use RefreshDatabase;


    /** 
     * Negatif Test 
     * Gagal menyimpan jika input kosong
     */
    public function test_store_menolak_input_kosong()
    {
        $response = $this->post(route('admin.questions.store'), []);
        $response->assertSessionHasErrors(['teks', 'jenis_pertanyaan_id', 'halaman_kuesioner_id', 'urutan']);
    }

    /** 
     * Positif Test 
     * Berhasil menyimpan dengan data valid
     */
    public function test_store_menerima_input_valid()
    {
        $jenis = JenisPertanyaan::factory()->create();
        $halaman = HalamanKuesioner::factory()->create();

        $data = [
            'teks' => 'Apa pekerjaan Anda?',
            'jenis_pertanyaan_id' => $jenis->id,
            'halaman_kuesioner_id' => $halaman->id,
            'urutan' => 1,
        ];

        $response = $this->post(route('admin.questions.store'), $data);
        $response->assertRedirect(route('admin.questions.index'));
        $this->assertDatabaseHas('pertanyaans', ['teks' => 'Apa pekerjaan Anda?']);
    }

    /** 
     * Boundary Test 
     * Panjang maksimal 255 karakter diterima
     */
    public function test_store_menerima_teks_dengan_panjang_maksimum()
    {
        $jenis = JenisPertanyaan::factory()->create();
        $halaman = HalamanKuesioner::factory()->create();

        $longText = str_repeat('A', 255);

        $data = [
            'teks' => $longText,
            'jenis_pertanyaan_id' => $jenis->id,
            'halaman_kuesioner_id' => $halaman->id,
            'urutan' => 2,
        ];

        $response = $this->post(route('admin.questions.store'), $data);
        $response->assertRedirect(route('admin.questions.index'));
        $this->assertDatabaseHas('pertanyaans', ['teks' => $longText]);
    }
}