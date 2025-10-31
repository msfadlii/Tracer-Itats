<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\HalamanKuesioner;
use Illuminate\Support\Str;
use App\Models\Pertanyaan;
use App\Models\JawabanAlumni;
use App\Models\JawabanMatrix;
use Illuminate\Http\Request;
use App\Models\Pengisian;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class AlumniFormController extends Controller
{
public function showForm(Request $request)
{
    // Buat UUID submission jika belum ada
    if (!session()->has('submission_id')) {
        session(['submission_id' => (string) Str::uuid()]);
    }

    // Ambil semua halaman dan pertanyaan + relasi
    $halamanKuesioners = HalamanKuesioner::with(['pertanyaans' => function ($query) {
        $query->with([
            'jenisPertanyaan',
            'opsiJawabans',
            'kondisiPertanyaan',
            'barisMatrixs'
        ])->orderBy('urutan');
    }])->orderBy('urutan')->get();

    // Parse atribut_ekstra JSON (scale dan matrix butuh ini)
    foreach ($halamanKuesioners as $halaman) {
        foreach ($halaman->pertanyaans as $pertanyaan) {
            $extra = $pertanyaan->atribut_ekstra;

            if (is_string($extra)) {
                $decoded = json_decode($extra, true);
                $pertanyaan->atribut_ekstra = is_array($decoded) ? $decoded : [];
            } elseif (!is_array($extra)) {
                $pertanyaan->atribut_ekstra = [];
            }
        }
    }

    return view('alumni.form', [
        'halamanKuesioners' => $halamanKuesioners,
    ]);
}

public function storeForm(Request $request)
{
    $validated = $request->validate([
        'tahun_lulus'       => ['required', 'integer', 'min:1980', 'max:'.(date('Y')+1)],
        'npm'               => ['required', 'regex:/^\d{12}$/', 'unique:alumnis,npm'],
        'nama'              => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\.]+$/'],
        'nik'               => ['required', 'string', 'regex:/^\d{16}$/', 'unique:alumnis,nik'],
        'tanggal_lahir'     => ['required', 'date', 'before:today', 'after:1950-01-01'],
        'email'             => 'required|email|unique:alumnis,email',
        'telepon'           => ['required', 'regex:/^(\+62|62|0)[0-9]{9,13}$/'],
        'npwp'              => ['nullable', 'regex:/^\d{2}\.\d{3}\.\d{3}\.\d{1}-\d{3}\.\d{3}$/'],
        'dosen_pembimbing'  => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\.,]+$/'],
        'pembiayaan'        => 'nullable|string|max:255',
        'status'            => 'required|string',
    ], [
        'nik.regex' => 'NIK harus berupa 16 digit angka tanpa spasi atau karakter lain.',
        'npm.regex' => 'NPM harus berupa 12 digit angka.',
        'nama.regex' => 'Nama hanya boleh berisi huruf, spasi, dan titik.',
        'tanggal_lahir.before' => 'Tanggal lahir tidak boleh di masa depan.',
        'tanggal_lahir.after' => 'Tanggal lahir tidak valid (minimal tahun 1950).',
        'tahun_lulus.min' => 'Tahun lulus minimal 1980.',
        'tahun_lulus.max' => 'Tahun lulus maksimal tahun depan.',
        'telepon.regex' => 'Format nomor telepon tidak valid. Gunakan format Indonesia: 08xx, 62xx, atau +62xx.',
        'npwp.regex' => 'Format NPWP tidak valid. Gunakan format: XX.XXX.XXX.X-XXX.XXX',
        'dosen_pembimbing.regex' => 'Nama dosen hanya boleh berisi huruf, spasi, titik, dan koma.',
    ]);

    DB::beginTransaction();

    try {
        // Simpan alumni
        $alumni = Alumni::create([
            'tahun_lulus'       => $request->tahun_lulus,
            'npm'               => $request->npm,
            'nama'              => $request->nama,
            'nik'               => $request->nik,
            'tanggal_lahir'     => $request->tanggal_lahir,
            'email'             => $request->email,
            'telepon'           => $request->telepon,
            'npwp'              => $request->npwp,
            'dosen_pembimbing'  => $request->dosen_pembimbing,
            'pembiayaan' => $request->pembiayaan === 'Yang lain' && $request->filled('pembiayaan_lainnya')
                            ? $request->pembiayaan_lainnya
                            : $request->pembiayaan,
            'status'            => $request->status,
        ]);

        // Simpan pengisian
        $submissionId = session('submission_id', (string) Str::uuid());

        $pengisian = Pengisian::create([
            'alumni_id'     => $alumni->id,
            'submission_id' => $submissionId,
        ]);
        Log::info('Pengisian created', ['id' => $pengisian->id]);

$statusKerja = $request->input('status');

// Ambil semua ID pertanyaan yang cocok untuk status ini
$pertanyaanValid = Pertanyaan::whereHas('kondisiPertanyaan', function ($query) use ($statusKerja) {
    $query->where('nilai_status_kerja', $statusKerja);
})->orWhereDoesntHave('kondisiPertanyaan') // pertanyaan tanpa kondisi dianggap universal
->pluck('id')->toArray();


   $jawaban = $request->input('answers', []);
    $jawabanLain = $request->input('answers_lain', []);

foreach ($jawaban as $pertanyaanId => $isiJawaban) {
    if (!in_array($pertanyaanId, $pertanyaanValid)) {
        Log::info(" Skip pertanyaan $pertanyaanId karena tidak sesuai status '$statusKerja'");
        continue;
    }

    $jawabanFinal = is_array($isiJawaban) ? json_encode($isiJawaban) : $isiJawaban;

    $jawabanFinal = $isiJawaban;

    if (is_array($isiJawaban)) {
        // Checkbox: jika ada value "Lainnya", ganti dengan input manual
        if (in_array("Lainnya", $isiJawaban) && isset($jawabanLain[$pertanyaanId])) {
            // Hanya ganti satu elemen "Lainnya" dengan jawaban manual
            $replaced = false;
            $filtered = array_map(function ($val) use (&$replaced, $jawabanLain, $pertanyaanId) {
                if ($val === "Lainnya" && !$replaced) {
                    $replaced = true;
                    return $jawabanLain[$pertanyaanId];
                }
                return $val;
            }, $isiJawaban);
            $jawabanFinal = json_encode($filtered);
        }  else {
            $jawabanFinal = json_encode($isiJawaban);
        }
    } else {
        // Radio: kalau jawaban == "Lainnya" dan ada input teks-nya
        if ($isiJawaban === "Lainnya" && isset($jawabanLain[$pertanyaanId])) {
            $jawabanFinal = $jawabanLain[$pertanyaanId];
        }
    }
            if (!is_null($jawabanFinal) && $jawabanFinal !== '') {
            Log::info('✅ JawabanAlumni akan disimpan', [
                'pengisian_id'  => $pengisian->id,
                'pertanyaan_id' => $pertanyaanId,
                'jawaban'       => $jawabanFinal,
            ]);

            JawabanAlumni::create([
                'pengisian_id'  => $pengisian->id,
                'pertanyaan_id' => $pertanyaanId,
                'jawaban'       => $jawabanFinal,
            ]);
        } else {
            Log::warning("⚠️ Jawaban kosong untuk pertanyaan $pertanyaanId — tidak disimpan.");
        }

}

foreach ($request->input('matrix_answers', []) as $pertanyaanId => $barisJawaban) {
    if (!in_array($pertanyaanId, $pertanyaanValid)) {
        Log::info(" Skip matrix pertanyaan $pertanyaanId karena tidak sesuai status '$statusKerja'");
        continue;
    }

    foreach ($barisJawaban as $barisId => $nilai) {
        Log::info(' JawabanMatrix akan disimpan', [
            'pengisian_id'    => $pengisian->id,
            'pertanyaan_id'   => $pertanyaanId,
            'baris_matrix_id' => $barisId,
            'jawaban'         => $nilai,
        ]);

        JawabanMatrix::create([
            'pengisian_id'     => $pengisian->id,
            'pertanyaan_id'    => $pertanyaanId,
            'baris_matrix_id'  => $barisId,
            'jawaban'          => $nilai,
        ]);
    }
}

        DB::commit();
        session()->forget('submission_id');

        Log::info('Form saved successfully for alumni_id: ' . $alumni->id);

        return redirect()->route('alumni.form.success')
            ->with('success', 'Jawaban berhasil disimpan. Terima kasih atas partisipasi Anda!');
    } catch (\Exception $e) {
        DB::rollBack();

        Log::error('Gagal menyimpan data form', [
            'message' => $e->getMessage(),
            'trace'   => $e->getTraceAsString(),
        ]);

        return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
    }
}

}
