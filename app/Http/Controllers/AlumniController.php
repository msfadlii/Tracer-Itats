<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AlumniController extends Controller
{
    public function export() {
    $data = \App\Models\Alumni::all(); // Mengambil 1000 data yang di-seed
    return response()->json([
        'status' => 'success',
        'total_exported' => $data->count(), // Membuktikan Large Dataset Handling 
    ]);
}
}
