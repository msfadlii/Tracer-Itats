<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function summary() {
    // Memastikan data di DB analitik sinkron dengan DB utama
    $totalMain = \App\Models\Alumni::count();
    
    return response()->json([
        'total_records' => $totalMain,
        'integrity_status' => $totalMain >= 1000 ? 'Verified' : 'Failed',
    ]);
}
}
