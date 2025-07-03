<?php

namespace App\Http\Controllers\Admin;

use App\Models\Alumni;
use Illuminate\Http\Request;
use App\Models\WaktuTungguKerja;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

public function showdashboard()
{
    // Total alumni
    $alumni = Alumni::count();

    // Distribusi status kerja alumni
    $statusAlumni = Alumni::whereNotNull('status')
        ->select('status', DB::raw('count(*) as total'))
        ->groupBy('status')
        ->orderBy('status')
        ->get();

    $statusAlumniLabels = $statusAlumni->pluck('status');
    $statusAlumniData = $statusAlumni->pluck('total');

    // Distribusi alumni per angkatan (tahun lulus)
    $angkatan = Alumni::select('tahun_lulus', DB::raw('COUNT(*) as total'))
        ->groupBy('tahun_lulus')
        ->orderBy('tahun_lulus')
        ->get();

    $angkatanLabels = $angkatan->pluck('tahun_lulus');
    $angkatanData = $angkatan->pluck('total');

    return view('admin.dashboard', compact(
        'alumni',
        'statusAlumniLabels', 'statusAlumniData',
        'angkatanLabels', 'angkatanData'
    ));
}

}
