<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alumni;
use App\Models\Pengisian;
use App\Models\Pertanyaan;

class AnswerController extends Controller
{
    public function destroyBySubmission($idPengisian)
    {
        $pengisian = Pengisian::with('alumni', 'jawabanAlumni')->findOrFail($idPengisian);
        $pengisian->jawabanAlumni()->delete();
        $pengisian->alumni()->delete();
        $pengisian->delete();

        return redirect()->back()->with('success', 'Data alumni dan jawabannya berhasil dihapus.');
    }

    public function showAnswers()
    {
        $kataKunci = request('keyword');
        $denganFilterPertanyaan = !empty($kataKunci);

        $daftarIdPertanyaan = [];
        $daftarPertanyaan = collect();

        if ($denganFilterPertanyaan) {
            $daftarPertanyaan = Pertanyaan::where('teks', 'like', '%' . $kataKunci . '%')->get();
            $daftarIdPertanyaan = $daftarPertanyaan->pluck('id')->toArray();
        } else {
            $daftarPertanyaan = Pertanyaan::all();
        }

        $kueriPengisian = Pengisian::with([
            'alumni',
            'jawabanAlumni.pertanyaan',
            'jawabanAlumni.pertanyaan.jenisPertanyaan',
            'jawabanAlumni.pertanyaan.kondisiPertanyaan',
        ]);

        if ($denganFilterPertanyaan && count($daftarIdPertanyaan) > 0) {
            $kueriPengisian->whereHas('jawabanAlumni', function ($q) use ($daftarIdPertanyaan) {
                $q->whereIn('pertanyaan_id', $daftarIdPertanyaan)
                  ->whereNotNull('jawaban')
                  ->where('jawaban', '!=', '');
            });
        }

        if ($tanggalIsi = request('start_date')) {
            $kueriPengisian->whereDate('created_at', $tanggalIsi);
        }

        if (($tahunLulus = request('tahun_lulus')) && $tahunLulus !== 'all') {
            $kueriPengisian->whereHas('alumni', function ($q) use ($tahunLulus) {
                $q->where('tahun_lulus', $tahunLulus);
            });
        }

        if (($statusKerja = request('status_kerja')) && $statusKerja !== 'all') {
            $kueriPengisian->whereHas('alumni', function ($q) use ($statusKerja) {
                $q->where('status', $statusKerja);
            });
        }

        // Search functionality - search in alumni data and answers
        if ($search = request('search')) {
            $kueriPengisian->where(function ($query) use ($search) {
                $query->whereHas('alumni', function ($q) use ($search) {
                    $q->where('nama', 'like', '%' . $search . '%')
                      ->orWhere('npm', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%')
                      ->orWhere('status', 'like', '%' . $search . '%')
                      ->orWhere('tahun_lulus', 'like', '%' . $search . '%')
                      ->orWhere('dosen_pembimbing', 'like', '%' . $search . '%');
                })->orWhereHas('jawabanAlumni', function ($q) use ($search) {
                    $q->where('jawaban', 'like', '%' . $search . '%');
                });
            });
        }

        // Get total count for all filtered data (before pagination)
        $totalKeseluruhan = $kueriPengisian->count();
        
        $daftarPengisian = $kueriPengisian->paginate(10)->withQueryString();
        
        $dataAlumni = [];

        foreach ($daftarPengisian as $pengisian) {
            $alumni = $pengisian->alumni;
            $status = $alumni->status;

            $pertanyaanSesuai = Pertanyaan::with(['jenisPertanyaan', 'kondisiPertanyaan'])
                ->whereDoesntHave('kondisiPertanyaan')
                ->orWhereHas('kondisiPertanyaan', function ($q) use ($status) {
                    $q->where('nilai_status_kerja', $status);
                })
                ->orderBy('urutan')
                ->get();

            $baris = [
                'id_pengisian' => $pengisian->id,
                'tanggal_isi' => $pengisian->created_at,
                'alumni' => $alumni,
            ];

            foreach ($pertanyaanSesuai as $pertanyaan) {
                $baris[$pertanyaan->teks] = '-';
            }

            foreach ($pengisian->jawabanAlumni as $jawaban) {
                if (
                    $jawaban->pertanyaan &&
                    $pertanyaanSesuai->pluck('id')->contains($jawaban->pertanyaan_id)
                ) {
                    $baris[$jawaban->pertanyaan->teks] = $jawaban->jawaban;
                }
            }

            $dataAlumni[] = $baris;
        }

        $daftarTahunLulus = Alumni::pluck('tahun_lulus')->unique()->sort()->values();
        $daftarStatusKerja = Alumni::pluck('status')->unique()->sort()->values();

        return view('admin.alumni_answers.index', [
            'pertanyaans' => $daftarPertanyaan,
            'pengisians' => $daftarPengisian,
            'dataAlumni' => $dataAlumni,
            'totalKeseluruhan' => $totalKeseluruhan,
            'tahunLulusTersedia' => $daftarTahunLulus,
            'statusKerjaTersedia' => $daftarStatusKerja,
            'denganFilterPertanyaan' => $denganFilterPertanyaan,
        ]);
    }

    // public function detailJawaban($idPengisian)
    // {
        
    //     try {
    //         $pengisian = Pengisian::with([
    //             'alumni',
    //             'jawabanAlumni.pertanyaan',
    //             'jawabanAlumni.pertanyaan.jenisPertanyaan',
    //             'jawabanAlumni.pertanyaan.kondisiPertanyaan',
    //             'jawabanMatrix.pertanyaan',
    //             'jawabanMatrix.barisMatrix'
    //         ])->findOrFail($idPengisian);

    //         $alumni = $pengisian->alumni;
    //         $statusAlumni = $alumni->status;

    //         $daftarPertanyaan = Pertanyaan::with(['jenisPertanyaan', 'kondisiPertanyaan'])
    //             ->whereDoesntHave('kondisiPertanyaan')
    //             ->orWhereHas('kondisiPertanyaan', function ($query) use ($statusAlumni) {
    //                 $query->where('nilai_status_kerja', $statusAlumni);
    //             })
    //             ->orderBy('urutan')
    //             ->get();

    //         $jawabanBiasa = [];
    //         foreach ($daftarPertanyaan as $pertanyaan) {
    //             $jawaban = $pengisian->jawabanAlumni
    //                 ->where('pertanyaan_id', $pertanyaan->id)
    //                 ->first();

    //             $jawabanBiasa[] = [
    //                 'id' => $pertanyaan->id,
    //                 'teks_pertanyaan' => $pertanyaan->teks,
    //                 'jenis' => $pertanyaan->jenisPertanyaan->nama,
    //                 'jawaban' => $jawaban ? $jawaban->jawaban : null,
    //             ];
    //         }

    //         $jawabanMatrix = $pengisian->jawabanMatrix->groupBy('pertanyaan_id')->map(function ($group) {
    //             $pertanyaan = $group->first()->pertanyaan;
    //             return [
    //                 'id' => $pertanyaan->id,
    //                 'teks_pertanyaan' => $pertanyaan->teks,
    //                 'jenis' => 'matrix',
    //                 'jawaban_baris' => $group->map(function ($jm) {
    //                     return [
    //                         'baris' => $jm->barisMatrix->label,
    //                         'jawaban' => $jm->jawaban,
    //                     ];
    //                 })->values(),
    //             ];
    //         })->values();

    //         return response()->json([
    //             'alumni' => [
    //                 'nama' => $alumni->nama,
    //                 'npm' => $alumni->npm,
    //                 'status' => $alumni->status,
    //                 'tahun_lulus' => $alumni->tahun_lulus,
    //                 'email' => $alumni->email,
    //                 'dosen_pembimbing' => $alumni->dosen_pembimbing,
    //             ],
    //              'jawaban' => array_merge($jawabanBiasa, $jawabanMatrix->toArray()),
    //         ]);
    //      } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
    //     return response()->json([
    //         'error' => 'Submission dengan ID ' . $idPengisian . ' tidak ditemukan.'
    //     ], 404);
    // } catch (\Exception $e) {
    //     return response()->json([
    //         'error' => 'Terjadi kesalahan server: ' . $e->getMessage()
    //     ], 500);
    // }
    // }

    public function detailJawaban($idPengisian)
{
    try {
        $pengisian = Pengisian::with([
            'alumni',
            'jawabanAlumni.pertanyaan',
            'jawabanAlumni.pertanyaan.jenisPertanyaan',
            'jawabanAlumni.pertanyaan.kondisiPertanyaan',
            'jawabanMatrix.pertanyaan.kondisiPertanyaan',
            'jawabanMatrix.barisMatrix'
        ])->findOrFail($idPengisian);

        $alumni = $pengisian->alumni;
        $statusAlumni = $alumni->status;

        // Filter jawaban biasa berdasarkan status alumni
        $jawabanBiasa = $pengisian->jawabanAlumni->filter(function ($jawaban) use ($statusAlumni) {
            $pertanyaan = $jawaban->pertanyaan;

            if (!$pertanyaan) return false;

            $kondisi = $pertanyaan->kondisiPertanyaan;

            // Jika tidak ada kondisi, pertanyaan berlaku umum
            if ($kondisi->isEmpty()) return true;

            // Jika ada kondisi, cocokkan status
            return $kondisi->contains('nilai_status_kerja', $statusAlumni);
        })->map(function ($jawaban) {
            return [
                'id' => $jawaban->pertanyaan->id,
                'teks_pertanyaan' => $jawaban->pertanyaan->teks,
                'jenis' => $jawaban->pertanyaan->jenisPertanyaan->nama,
                'jawaban' => $jawaban->jawaban,
            ];
        })->values();

        // Filter jawaban matrix berdasarkan status alumni
        $jawabanMatrix = $pengisian->jawabanMatrix
            ->groupBy('pertanyaan_id')
            ->map(function ($group) use ($statusAlumni) {
                $pertanyaan = $group->first()->pertanyaan;

                if (!$pertanyaan) return null;

                $kondisi = $pertanyaan->kondisiPertanyaan;

                if ($kondisi->isNotEmpty() && !$kondisi->contains('nilai_status_kerja', $statusAlumni)) {
                    return null;
                }

                return [
                    'id' => $pertanyaan->id,
                    'teks_pertanyaan' => $pertanyaan->teks,
                    'jenis' => 'matrix',
                    'jawaban_baris' => $group->map(function ($jm) {
                        return [
                            'baris' => $jm->barisMatrix->label,
                            'jawaban' => $jm->jawaban,
                        ];
                    })->values(),
                ];
            })
            ->filter()
            ->values();

        return response()->json([
            'alumni' => [
                'nama' => $alumni->nama,
                'npm' => $alumni->npm,
                'status' => $alumni->status,
                'tahun_lulus' => $alumni->tahun_lulus,
                'email' => $alumni->email,
                'dosen_pembimbing' => $alumni->dosen_pembimbing,
            ],
            'jawaban' => array_merge($jawabanBiasa->toArray(), $jawabanMatrix->toArray()),
        ]);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json([
            'error' => 'Submission dengan ID ' . $idPengisian . ' tidak ditemukan.'
        ], 404);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Terjadi kesalahan server: ' . $e->getMessage()
        ], 500);
    }
}

}
