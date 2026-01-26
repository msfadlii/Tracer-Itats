<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\AnalyticsAlumni;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function summary() {
        try {
            // 1. Ambil data dari DB Analitik (Koneksi mysql_analytics)
            // Jika koneksi docker salah, baris ini akan error (Exception)
            $analyticsCount = AnalyticsAlumni::count();

            // 2. (Opsional) Bandingkan dengan DB Utama untuk validasi integritas
            $mainCount = Alumni::count();
            
            // Validasi integritas: Data analitik harus sinkron (sama jumlahnya) dengan data utama
            // dan jumlahnya harus >= 1000 sesuai syarat Large Dataset
            $isIntegrityVerified = ($analyticsCount === $mainCount) && ($analyticsCount >= 1000);

            return response()->json([
                'status' => 'success',
                'check_type' => 'Dual Database Integrity Check',
                'data_integrity' => $isIntegrityVerified ? 'Verified' : 'Discrepancy/Incomplete',
                'records_in_analytics_db' => $analyticsCount,
                'records_in_main_db' => $mainCount,
                'source' => 'db_analytics (container: tc_db_analytics)' 
            ], 200);

        } catch (\Exception $e) {
            // Ini akan menangkap jika koneksi ke db_analytics gagal
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal terhubung ke Database Analitik. Cek Docker Network.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
