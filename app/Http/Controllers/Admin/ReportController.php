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
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{

    public function showReport(Request $request)
    {
        // Debug: Log semua request data
        Log::info('Request data:', $request->all());
        
        // Ambil daftar halaman kuesioner sebagai kategori utama
        $halamanKuesioners = HalamanKuesioner::orderBy('urutan')->get();

        // Ambil filter dasar
        $graduationYears = Alumni::selectRaw('DISTINCT tahun_lulus')
            ->orderByDesc('tahun_lulus')
            ->pluck('tahun_lulus')
            ->map(function($year) {
                return (int) $year; // Pastikan semua tahun adalah integer
            })
            ->toArray();
            
        $employmentStatuses = Alumni::selectRaw('DISTINCT status')->pluck('status')->toArray();

        // Filter dari request - ensure selectedYears is always an array
        $selectedYears = $request->input('graduation_year', []);
        
        // Debug: Log raw input
        Log::info('Raw graduation_year input:', ['input' => $selectedYears]);
        
        // Pastikan selectedYears adalah array
        if (!is_array($selectedYears)) {
            $selectedYears = $selectedYears ? [$selectedYears] : [];
        }
        
        // Filter out empty values dan convert ke integer
        $selectedYears = array_filter($selectedYears, function($year) {
            return !empty($year) && $year !== '';
        });
        
        $selectedYears = array_map('intval', $selectedYears);
        
        // Debug: Log processed selectedYears
        Log::info('Processed selectedYears:', ['selected' => $selectedYears]);

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

        // Debug: Log data yang akan dikirim ke view
        Log::info('Data sent to view:', [
            'graduationYears' => $graduationYears,
            'selectedYears' => $selectedYears,
            'selectedStatus' => $selectedStatus
        ]);
        $chartType = $request->input('chart_type', 'bar'); // default bar

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
            'selectedStatus',
            'chartType'
        ));

    }
}