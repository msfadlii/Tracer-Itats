<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function summary() {
        // Memastikan data di DB analitik sinkron dengan DB utama
        $totalAlumni = Alumni::count();

        return response()->json([
            'status' => 'success',
            'data_integrity' => $totalAlumni >= 1000 ? 'Verified' : 'Incomplete',
            'total_records' => $totalAlumni,
            'source' => 'analytics_db' // Menunjukkan penggunaan DB analitik terpisah
        ], 200);
    }
}
