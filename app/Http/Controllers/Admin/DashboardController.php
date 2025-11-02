<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alumni;
use App\Models\WaktuTungguKerja;
use App\Models\Pertanyaan;
use App\Models\JawabanAlumni;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function showdashboard(Request $request)
    {
        // Check if this is a reset request (no filter parameters and came from reset button)
        if (!$request->filled('tahun') && !$request->filled('status') && $request->headers->get('referer')) {
            $referer = parse_url($request->headers->get('referer'), PHP_URL_QUERY);
            if ($referer && (str_contains($referer, 'tahun=') || str_contains($referer, 'status='))) {
                session()->flash('filter_reset', 'Filter data berhasil direset');
            }
        }

        $query = Alumni::query();

        if ($request->filled('tahun')) {
            $query->where('tahun_lulus', $request->tahun);
        }
        if ($request->filled('status')) {
            $query->where('status', 'like', '%' . $request->status . '%');
        }

        $alumni = $query->count();
        $alumniBekerja = $query->clone()->where('status', 'like', '%Bekerja%')->count();


        // Gaji
        $gajiPertanyaanId = Pertanyaan::where('teks', 'like', '%gaji%')->value('id');
        $gajiAvg = null;

        if ($gajiPertanyaanId) {
            $gajiAvg =JawabanAlumni::where('pertanyaan_id', $gajiPertanyaanId)
                ->join('pengisians', 'jawaban_alumnis.pengisian_id', '=', 'pengisians.id')
                ->join('alumnis', 'pengisians.alumni_id', '=', 'alumnis.id')
                ->when($request->filled('tahun'), fn($q) => $q->where('alumnis.tahun_lulus', $request->tahun))
                ->when($request->filled('status'), fn($q) => $q->where('alumnis.status', 'like', '%' . $request->status . '%'))
                ->pluck('jawaban')
                ->map(fn($j) => (int) filter_var($j, FILTER_SANITIZE_NUMBER_INT))
                ->avg();
        }

        // Distribusi Status Alumni (Chart)
        $distribusiStatus = Alumni::query()
            ->when($request->filled('tahun'), fn($q) => $q->where('tahun_lulus', $request->tahun))
            ->when($request->filled('status'), fn($q) => $q->where('status', 'like', '%' . $request->status . '%'))
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->get();

        // Alumni per Tahun (Chart)
        $alumniPerTahun = Alumni::query()
            ->when($request->filled('status'), fn($q) => $q->where('status', 'like', '%' . $request->status . '%'))
            ->select('tahun_lulus', DB::raw('COUNT(*) as total'))
            ->groupBy('tahun_lulus')
            ->orderBy('tahun_lulus')
            ->get();

        // Top Perusahaan (Jawaban Alumni)
        $perusahaanPertanyaanId = Pertanyaan::where('teks', 'like', '%perusahaan%')->value('id');
        $topPerusahaan = collect();

        if ($perusahaanPertanyaanId) {
            $topPerusahaan = JawabanAlumni::where('pertanyaan_id', $perusahaanPertanyaanId)
                ->join('pengisians', 'jawaban_alumnis.pengisian_id', '=', 'pengisians.id')
                ->join('alumnis', 'pengisians.alumni_id', '=', 'alumnis.id')
                ->when($request->filled('tahun'), fn($q) => $q->where('alumnis.tahun_lulus', $request->tahun))
                ->when($request->filled('status'), fn($q) => $q->where('alumnis.status', 'like', '%' . $request->status . '%'))
                ->select('jawaban_alumnis.jawaban as nama_perusahaan', DB::raw('COUNT(*) as total'))
                ->groupBy('jawaban_alumnis.jawaban')
                ->orderByDesc('total')
                ->limit(5)
                ->get();
        }

        // Gaji per Tahun (Chart Line)
        $gajiPerTahun = collect();
        if ($gajiPertanyaanId) {
            $gajiPerTahun = JawabanAlumni::where('jawaban_alumnis.pertanyaan_id', $gajiPertanyaanId)
                ->join('pengisians', 'jawaban_alumnis.pengisian_id', '=', 'pengisians.id')
                ->join('alumnis', 'pengisians.alumni_id', '=', 'alumnis.id')
                ->when($request->filled('status'), fn($q) => $q->where('alumnis.status', 'like', '%' . $request->status . '%'))
                ->when($request->filled('tahun'), fn($q) => $q->where('alumnis.tahun_lulus', $request->tahun))
                ->select('alumnis.tahun_lulus as tahun', DB::raw('AVG(CAST(jawaban_alumnis.jawaban AS SIGNED)) as rata'))
                ->groupBy('alumnis.tahun_lulus')
                ->orderBy('alumnis.tahun_lulus')
                ->get();
        }

        // Pilihan Tahun untuk Dropdown Filter
        $tahunOptions = Alumni::select('tahun_lulus')->distinct()->orderBy('tahun_lulus')->pluck('tahun_lulus');

        return view('admin.dashboard', compact(
            'alumni',
            'alumniBekerja',
            'gajiAvg',
            'distribusiStatus',
            'alumniPerTahun',
            'topPerusahaan',
            'gajiPerTahun',
            'tahunOptions'
        ));
    }



}
