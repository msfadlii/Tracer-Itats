<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pertanyaan;
use App\Models\JenisPertanyaan;
use App\Models\HalamanKuesioner;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;


use function Laravel\Prompts\search;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $selectedStatus = $request->get('status');
        log::info($selectedStatus);

        $query = Pertanyaan::with(['jenisPertanyaan', 'opsiJawabans', 'kondisiPertanyaan','barisMatrixs'])
            ->when($search, fn($q) => $q->where('teks', 'like', '%' . $search . '%'));

        if ($selectedStatus) {
            $query->whereHas('kondisiPertanyaan', fn($q) =>
                $q->where('field', 'status')->where('nilai_status_kerja', $selectedStatus)
            );
        }

        $questions = $query->paginate(10)->appends($request->query());

        $statusList = [
            'Bekerja (full time/part time)',
            'Belum Memungkinkan Bekerja',
            'Wiraswasta',
            'Melanjutkan Pendidikan',
            'Tidak Kerja Tetapi Sedang Mencari Kerja',
        ];

        return view('admin.questions.index', compact('questions', 'statusList'));
    }

    public function create()
    {
        return view('admin.questions.create', [
            'statusList' => [
                'Bekerja (full time/part time)',
                'Belum Memungkinkan Bekerja',
                'Wiraswasta',
                'Melanjutkan Pendidikan',
                'Tidak Kerja Tetapi Sedang Mencari Kerja',
            ],
            'questionTypes' => JenisPertanyaan::all(),
            'halamanKuesioners' => HalamanKuesioner::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'teks' => 'required|string|max:255',
            'jenis_pertanyaan_id' => 'required|exists:jenis_pertanyaans,id',
            'halaman_kuesioner_id' => 'required|exists:halaman_kuesioners,id',
            'urutan' => [
                'required',
                'integer',
                Rule::unique('pertanyaans')->where(fn($q) =>
                    $q->where('halaman_kuesioner_id', $request->halaman_kuesioner_id)
                ),
            ],
            'opsi' => 'nullable|array',
            'punya_opsi_lain' => 'nullable|boolean',
            'wajib' => 'nullable|boolean',
            'visualisasi' => 'nullable|boolean',
            'skala_range' => 'nullable|string',
            'skala_labels' => 'nullable|string',
            'matrix_rows' => 'nullable|array',
            'matrix_columns' => 'nullable|array',
            'employment_conditions' => 'nullable|array',
        ]);

        // Validasi tambahan untuk tipe scale
        $scaleId = JenisPertanyaan::where('nama', 'scale')->value('id');
        if ($request->jenis_pertanyaan_id == $scaleId) {
            $request->validate([
                'skala_range' => ['required', 'regex:/^\d+\s*-\s*\d+$/'],
            ]);
        }

        $jenis = JenisPertanyaan::findOrFail($validated['jenis_pertanyaan_id']);
        $typeName = $jenis->nama;
        $atributEkstra = null;
        $opsi = [];

        if ($typeName === 'scale' && $request->skala_range) {
            [$start, $end] = explode('-', str_replace(' ', '', $request->skala_range));
            $opsi = range((int)$start, (int)$end);
            $atributEkstra = [
                'range' => [$start, $end],
                'labels' => $request->skala_labels ? array_map('trim', explode(',', $request->skala_labels)) : null,
            ];
        }

        if ($typeName === 'matrix' && $request->matrix_rows && $request->matrix_columns) {
            $atributEkstra = [
                'columns' => array_map('trim', $request->matrix_columns),
            ];
        }

        $pertanyaan = Pertanyaan::create([
            ...$validated,
            'wajib' => $request->boolean('wajib'),
            'punya_opsi_lain' => $request->boolean('punya_opsi_lain'),
            'visualisasi' => $request->boolean('visualisasi'),
            'atribut_ekstra' => $atributEkstra ? json_encode($atributEkstra) : null,
        ]);

        // Simpan opsi jawaban
        if (in_array($typeName, ['select', 'radio', 'checkbox']) && $request->opsi) {
            foreach ($request->opsi as $index => $teksOpsi) {
                $pertanyaan->opsiJawabans()->create([
                    'teks' => trim($teksOpsi),
                    'urutan' => $index,
                ]);
            }
        }

        // Simpan opsi skala
        if ($typeName === 'scale' && !empty($opsi)) {
            foreach ($opsi as $index => $nilai) {
                $pertanyaan->opsiJawabans()->create([
                    'teks' => (string)$nilai,
                    'urutan' => $index,
                ]);
            }
        }

        // Simpan matrix rows
        if ($typeName === 'matrix' && $request->matrix_rows) {
            foreach ($request->matrix_rows as $row) {
                $pertanyaan->barisMatrixs()->create([
                    'label' => trim($row),
                ]);
            }
        }

        // Simpan kondisi status kerja
        $statusList = [
            'Bekerja (full time/part time)',
            'Belum Memungkinkan Bekerja',
            'Wiraswasta',
            'Melanjutkan Pendidikan',
            'Tidak Kerja Tetapi Sedang Mencari Kerja',
        ];

        $selectedConditions = $validated['employment_conditions'] ?? [];
        $conditionsToSave = empty($selectedConditions) ? $statusList : $selectedConditions;

        foreach ($conditionsToSave as $status) {
            $pertanyaan->kondisiPertanyaan()->create([
                'field' => 'status',
                'nilai_status_kerja' => $status,
            ]);
        }

        return redirect()->route('admin.questions.index')->with('success', 'Pertanyaan berhasil disimpan.');
    }
public function edit(Pertanyaan $question)
{
    $question->load(['jenisPertanyaan', 'opsiJawabans', 'barisMatrixs', 'kondisiPertanyaan']);

    $selectedConditions = $question->kondisiPertanyaan
        ->where('field', 'status')
        ->pluck('nilai_status_kerja')
        ->toArray();

    $atributEkstra = $question->atribut_ekstra
        ? json_decode($question->atribut_ekstra, true)
        : [];

    return view('admin.questions.edit', [
        'question' => $question,
        'statusList' => [
            'Bekerja (full time/part time)',
            'Belum Memungkinkan Bekerja',
            'Wiraswasta',
            'Melanjutkan Pendidikan',
            'Tidak Kerja Tetapi Sedang Mencari Kerja',
        ],
        'selectedConditions' => $selectedConditions,
        'questionTypes' => JenisPertanyaan::all(),
        'halamanKuesioners' => HalamanKuesioner::all(),
        'atributEkstra' => $atributEkstra,
    ]);
}

public function update(Request $request, Pertanyaan $question)
{
    $validated = $request->validate([
        'teks' => 'required|string|max:255',
        'jenis_pertanyaan_id' => 'required|exists:jenis_pertanyaans,id',
        'halaman_kuesioner_id' => 'required|exists:halaman_kuesioners,id',
        'urutan' => [
            'required',
            'integer',
            Rule::unique('pertanyaans')->where(fn($q) =>
                $q->where('halaman_kuesioner_id', $request->halaman_kuesioner_id)
            )->ignore($question->id),
        ],
        'opsi' => 'nullable|array',
        'urutan_opsi' => 'nullable|array',
        'opsi_ids' => 'nullable|array',
        'punya_opsi_lain' => 'nullable|boolean',
        'wajib' => 'nullable|boolean',
        'visualisasi' => 'nullable|boolean',
        'skala_labels' => 'nullable|array',
        'skala_ids' => 'nullable|array',
        'matrix_rows' => 'nullable|array',
        'matrix_row_ids' => 'nullable|array',
        'matrix_columns' => 'nullable|array',
        'matrix_column_ids' => 'nullable|array',
        'employment_conditions' => 'nullable|array',
    ]);

    $jenis = JenisPertanyaan::findOrFail($validated['jenis_pertanyaan_id']);
    $typeName = $jenis->nama;

    // Simpan info meta jika dibutuhkan
    $atributEkstra = null;
    if ($typeName === 'scale') {
    $existing = json_decode($question->atribut_ekstra, true) ?? [];

    $atributEkstra = [
        'range' => $existing['range'] ?? [],
        'labels' => $request->skala_labels ?? [],
    ];
  }elseif ($typeName === 'matrix') {
        $atributEkstra = ['columns' => $request->matrix_columns ?? []];
    }

    $question->update([
        ...$validated,
        'wajib' => $request->boolean('wajib'),
        'punya_opsi_lain' => $request->boolean('punya_opsi_lain'),
        'visualisasi' => $request->boolean('visualisasi'),
        'atribut_ekstra' => $atributEkstra ? json_encode($atributEkstra) : null,
    ]);

    // === OPSI JAWABAN ===
    if (in_array($typeName, ['select', 'radio', 'checkbox'])) {
        foreach ($request->opsi ?? [] as $i => $opsi) {
            $id = $request->opsi_ids[$i] ?? null;
            $urutan = $request->urutan_opsi[$i] ?? $i + 1;

            if ($id) {
                $question->opsiJawabans()->where('id', $id)->update([
                    'teks' => trim($opsi),
                    'urutan' => $urutan,
                ]);
            }
        }
    }

    // === SKALA – Update Label Berdasarkan ID ===
    if ($typeName === 'scale') {
        foreach ($request->skala_labels ?? [] as $i => $label) {
            $id = $request->skala_ids[$i] ?? null;
            if ($id) {
                $question->opsiJawabans()->where('id', $id)->update([
                    'teks' => trim($label),
                    'urutan' => $i + 1,
                ]);
            }
        }
    }

    // === MATRIX – Update Baris dan Kolom ===
    if ($typeName === 'matrix') {
        // Baris
        foreach ($request->matrix_rows ?? [] as $i => $label) {
            $id = $request->matrix_row_ids[$i] ?? null;
            if ($id) {
                $question->barisMatrixs()->where('id', $id)->update([
                    'label' => trim($label),
                ]);
            }
        }
    }

    // === KONDISI STATUS KERJA ===
    $question->kondisiPertanyaan()->delete();
    foreach ($request->employment_conditions ?? [] as $status) {
        $question->kondisiPertanyaan()->create([
            'field' => 'status',
            'nilai_status_kerja' => $status,
        ]);
    }

    return redirect()->route('admin.questions.index')->with('success', 'Pertanyaan berhasil diperbarui.');
}


public function destroy(Pertanyaan $question)
{
    $question->delete();
    return redirect()->route('admin.questions.index')->with('success', 'Pertanyaan berhasil dihapus!');
}
}
