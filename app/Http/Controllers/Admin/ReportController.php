<?php

namespace App\Http\Controllers\Admin;

use App\Models\Alumni;
use App\Models\HalamanKuesioner;
use Illuminate\Http\Request;
use App\Models\JawabanAlumni;
use App\Models\Pertanyaan;
use App\Models\JawabanMatrix;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{

public function showReport(Request $request)
{
    // Ambil daftar halaman kuesioner sebagai kategori utama
    $halamanKuesioners = HalamanKuesioner::orderBy('urutan')->get();

    // Ambil filter dasar
    $graduationYears = Alumni::selectRaw('DISTINCT tahun_lulus')->orderByDesc('tahun_lulus')->pluck('tahun_lulus')->toArray();
    $employmentStatuses = Alumni::selectRaw('DISTINCT status')->pluck('status')->toArray();

    // Filter dari request
    $selectedYears = $request->input('graduation_year', []);
    $selectedStatus = $request->input('employment_status', 'semua');
    $halamanId = $request->input('halaman_id');
    $pertanyaanId = $request->input('pertanyaan_id');

    $chartLabels = [];
    $chartCounts = [];

    // Ambil semua pertanyaan yang termasuk dalam halaman dan aktif untuk visualisasi
    $pertanyaans = collect();

    if ($halamanId) {
        $pertanyaans = Pertanyaan::where('halaman_kuesioner_id', $halamanId)
            ->where('visualisasi', 1)
            ->orderBy('urutan')
            ->get();
    }

    // Ambil detail pertanyaan yang dipilih (untuk tahu jenisnya)
    $pertanyaan = $pertanyaanId ? Pertanyaan::with('jenisPertanyaan')->find($pertanyaanId) : null;

    if ($pertanyaan) {
        $query = null;

        // Jenis pertanyaan biasa (bukan matrix)
        if ($pertanyaan->jenisPertanyaan->nama !== 'matrix') {
            $query = JawabanAlumni::query()
                ->join('pengisians', 'jawaban_alumnis.pengisian_id', '=', 'pengisians.id')
                ->join('alumnis', 'pengisians.alumni_id', '=', 'alumnis.id')
                ->where('jawaban_alumnis.pertanyaan_id', $pertanyaanId);
        }

        // Jenis matrix
        else {
            $query = JawabanMatrix::query()
                ->join('pengisians', 'jawaban_matrixs.pengisian_id', '=', 'pengisians.id')
                ->join('alumnis', 'pengisians.alumni_id', '=', 'alumnis.id')
                ->where('jawaban_matrixs.pertanyaan_id', $pertanyaanId);
        }

        if (!empty($selectedYears)) {
            $query->whereIn('alumnis.tahun_lulus', $selectedYears);
        }

        if ($selectedStatus !== 'semua') {
            $query->where('alumnis.status', $selectedStatus);
        }

        // Query data
        $data = $query->select('jawaban', DB::raw('COUNT(*) as total'))
            ->groupBy('jawaban')
            ->orderBy('jawaban')
            ->get();

        $chartLabels = $data->pluck('jawaban')->toArray();
        $chartCounts = $data->pluck('total')->toArray();
    }

    return view('admin.reports.index', compact(
        'halamanKuesioners',
        'halamanId',
        'pertanyaans',
        'pertanyaanId',
        'chartLabels',
        'chartCounts',
        'graduationYears',
        'employmentStatuses',
        'selectedYears',
        'selectedStatus'
    ));
}


// public function showReport(Request $request)
// {
//     $categories = [
//         'status' => 'Status Alumni',
//         'pertanyaan_biasa' => 'Pertanyaan (Bukan Matrix)',
//         'pertanyaan_matrix' => 'Pertanyaan Matrix',
//     ];

//     // Ambil filter dasar
//     $graduationYears = Alumni::selectRaw('DISTINCT tahun_lulus')
//         ->orderByDesc('tahun_lulus')
//         ->pluck('tahun_lulus')
//         ->toArray();

//     $employmentStatuses = Alumni::selectRaw('DISTINCT status')
//         ->pluck('status')
//         ->toArray();

//     $selectedYears = $request->input('graduation_year', []);
//     $selectedStatus = $request->input('employment_status', 'semua');
//     $category = $request->input('category');
//     $pertanyaanId = $request->input('pertanyaan_id');

//     $chartLabels = [];
//     $chartCounts = [];

//     // ===== Ambil daftar pertanyaan berdasarkan kategori =====
//     $pertanyaans = collect();

//     if ($category === 'pertanyaan_biasa') {
//         $pertanyaans = Pertanyaan::whereHas('jenisPertanyaan', fn ($q) =>
//             $q->where('nama', '!=', 'matrix')
//         )->orderBy('urutan')->get();
//     }

//     if ($category === 'pertanyaan_matrix') {
//         $pertanyaans = Pertanyaan::whereHas('jenisPertanyaan', fn ($q) =>
//             $q->where('nama', 'matrix')
//         )->orderBy('urutan')->get();
//     }

//     // ======= Kategori: Status =======
//     if ($category === 'status') {
//         $query = Alumni::query();

//         if (!empty($selectedYears)) {
//             $query->whereIn('tahun_lulus', $selectedYears);
//         }

//         $query->whereNotNull('status');

//         $data = $query->select('status', DB::raw('COUNT(*) as total'))
//             ->groupBy('status')
//             ->orderBy('status')
//             ->get();

//         $chartLabels = $data->pluck('status')->toArray();
//         $chartCounts = $data->pluck('total')->toArray();
//     }

//     // ======= Kategori: Pertanyaan Biasa =======
//     elseif ($category === 'pertanyaan_biasa' && $pertanyaanId) {
//         $query = JawabanAlumni::query()
//             ->join('pengisians', 'jawaban_alumnis.pengisian_id', '=', 'pengisians.id')
//             ->join('alumnis', 'pengisians.alumni_id', '=', 'alumnis.id')
//             ->where('jawaban_alumnis.pertanyaan_id', $pertanyaanId);

//         if (!empty($selectedYears)) {
//             $query->whereIn('alumnis.tahun_lulus', $selectedYears);
//         }

//         if ($selectedStatus !== 'semua') {
//             $query->where('alumnis.status', $selectedStatus);
//         }

//         $data = $query->select('jawaban', DB::raw('COUNT(*) as total'))
//             ->groupBy('jawaban')
//             ->orderBy('jawaban')
//             ->get();

//         $chartLabels = $data->pluck('jawaban')->toArray();
//         $chartCounts = $data->pluck('total')->toArray();
//     }

//     // ======= Kategori: Pertanyaan Matrix =======
//     elseif ($category === 'pertanyaan_matrix' && $pertanyaanId) {
//         $query = JawabanMatrix::query()
//             ->join('pengisians', 'jawaban_matrixs.pengisian_id', '=', 'pengisians.id')
//             ->join('alumnis', 'pengisians.alumni_id', '=', 'alumnis.id')
//             ->where('jawaban_matrixs.pertanyaan_id', $pertanyaanId);

//         if (!empty($selectedYears)) {
//             $query->whereIn('alumnis.tahun_lulus', $selectedYears);
//         }

//         if ($selectedStatus !== 'semua') {
//             $query->where('alumnis.status', $selectedStatus);
//         }

//         $data = $query->select('jawaban', DB::raw('COUNT(*) as total'))
//             ->groupBy('jawaban')
//             ->orderBy('jawaban')
//             ->get();

//         $chartLabels = $data->pluck('jawaban')->toArray();
//         $chartCounts = $data->pluck('total')->toArray();
//     }

//     return view('admin.reports.index', compact(
//         'categories',
//         'category',
//         'chartLabels',
//         'chartCounts',
//         'graduationYears',
//         'employmentStatuses',
//         'selectedYears',
//         'selectedStatus',
//         'pertanyaanId',
//         'pertanyaans'
//     ));
// }



}