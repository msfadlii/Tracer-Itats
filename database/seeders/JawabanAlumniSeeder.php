<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alumni;
use App\Models\Pengisian;
use App\Models\JawabanAlumni;

class JawabanAlumniSeeder extends Seeder
{
    public function run(): void
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        JawabanAlumni::truncate();
        Pengisian::truncate();
        Alumni::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $names = [
            'Andi Saputra',
            'Rina Marlina',
            'Dedi Kurniawan',
            'Lisa Apriani',
            'Agus Prasetyo',
            'Siti Nurhaliza',
            'Bambang Haryanto',
            'Mega Wulandari',
            'Rizky Maulana',
            'Nurul Aini'
        ];

        // Mapping status ke halaman kuesioner khusus
        $statusToHalaman = [
            'Bekerja (full time/part time)' => 1,
            'Wiraswasta' => 4,
            'Melanjutkan Pendidikan' => 3,
            // Status tanpa halaman khusus langsung ke kuesioner wajib (id=3)
            'Belum Memungkinkan Bekerja' => 3,
            'Tidak Kerja Tetapi Sedang Mencari Kerja' => 3,
        ];

        // Ambil semua pertanyaan sekali saja
        $allPertanyaan = \DB::table('pertanyaans')->select('id', 'halaman_kuesioner_id', 'teks')->get()->groupBy('halaman_kuesioner_id');

        foreach ($names as $index => $name) {
            $i = $index + 1;

            // Set status berulang sesuai index untuk variasi
            $statusList = array_keys($statusToHalaman);
            $status = $statusList[$i % count($statusList)];

            // Buat alumni baru
            $alumni = Alumni::create([
                'tahun_lulus' => 2015 + $i,
                'npm' => '19000000' . $i,
                'nama' => $name,
                'nik' => '32010101010100' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'tanggal_lahir' => '1990-01-' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'email' => strtolower(str_replace(' ', '.', $name)) . '@example.com',
                'telepon' => '081234567' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'npwp' => $i % 2 === 0 ? '12.345.678.9-0' . $i . '.000' : null,
                'dosen_pembimbing' => 'Dosen Pembimbing ' . $i,
                'pembiayaan' => $i % 3 === 0 ? 'Beasiswa' : 'Mandiri',
                'status' => $status,
            ]);

            $pengisian = Pengisian::create([
                'alumni_id' => $alumni->id,
            ]);

            // Halaman kuesioner khusus berdasarkan status
            $halamanKhusus = $statusToHalaman[$status];

            // Ambil pertanyaan khusus sesuai halaman kuesioner
            $pertanyaanKhusus = $allPertanyaan[$halamanKhusus] ?? collect();

            // Ambil pertanyaan wajib (halaman_kuesioner_id=3) yang selalu diisi
            $pertanyaanWajib = $allPertanyaan[3] ?? collect();

            // Gabungkan pertanyaan (halaman khusus + wajib)
            $pertanyaanGabungan = $pertanyaanKhusus->merge($pertanyaanWajib);

            foreach ($pertanyaanGabungan as $pertanyaan) {
                $id = $pertanyaan->id;
                $teks = $pertanyaan->teks;

                // Isi jawaban manual berdasar id atau teks pertanyaan
                $jawaban = match ($id) {
                    1 => '3 bulan setelah lulus', // waktu tunggu kerja
                    2 => 'Rp 4.000.000', // gaji pertama
                    3 => 'PT Teknologi Nusantara', // tempat kerja
                    5 => 'Jawa Barat', // domisili kerja
                    6 => 'Swasta', // jenis instansi
                    7 => 'Nasional', // skala perusahaan
                    8 => 'Erat', // relevansi pendidikan
                    9 => 'S1', // jenjang pendidikan
                    11 => 'Bandung', // lokasi kerja
                    12, 13 => json_encode([
                        'Keterampilan Teknis' => 'Tinggi',
                        'Komunikasi' => 'Cukup',
                        'Kerjasama Tim' => 'Tinggi',
                    ]),
                    15 => json_encode([
                        'Kuliah Lapangan' => 'Besar',
                        'Diskusi' => 'Cukup',
                    ]),
                    16 => 'Setelah lulus', // mulai cari kerja
                    17 => '2 bulan sebelum lulus', // mulai cari kerja
                    18 => 'Internet, Relasi', // sumber info lowongan
                    19 => '2', // jumlah lamaran
                    20 => '1', // jumlah panggilan interview
                    21 => '1', // jumlah tawaran kerja
                    22 => 'Ya', // aktif cari kerja
                    23 => 'Butuh penghasilan', // alasan kerja
                    24 => 'Orang tua', // sumber pembiayaan
                    25 => 'Universitas A', // perguruan tinggi
                    26 => 'Teknik Informatika', // program studi
                    28 => 'Erat', // relevansi studi lanjut
                    29 => '1 bulan', // mulai usaha wiraswasta
                    30 => 'Usaha Mandiri', // nama usaha
                    31 => 'Bandung', // lokasi usaha
                    32 => 'Rp 5.000.000', // pendapatan wiraswasta
                    33 => 'Jawa Barat', // provinsi usaha
                    36 => 'Owner', // jabatan wiraswasta
                    37 => 'Nasional', // tingkat wiraswasta
                    38 => 'Erat', // relevansi wiraswasta
                    40 => '2020-08-01', // tanggal masuk studi lanjut
                    default => 'Jawaban otomatis',
                };

                JawabanAlumni::create([
                    'pengisian_id' => $pengisian->id,
                    'pertanyaan_id' => $id,
                    'jawaban' => $jawaban,
                ]);
            }
        }
    }
}
