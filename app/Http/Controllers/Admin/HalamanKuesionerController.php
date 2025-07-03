<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HalamanKuesioner;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class HalamanKuesionerController extends Controller
{

    public function index()
    {
        $halamans = HalamanKuesioner::orderBy('urutan')->get();
        return view('admin.page_kuesioners.index', compact('halamans'));
    }

    public function create()
    {
        return view('admin.page_kuesioners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'urutan' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('halaman_kuesioners', 'urutan'),
            ],
        ]);

        HalamanKuesioner::create($request->only('judul', 'deskripsi', 'urutan'));

        return redirect()->route('admin.page_kuesioners.index')
                         ->with('success', 'Halaman berhasil ditambahkan.');
    }

    public function edit(HalamanKuesioner $page_kuesioner)
    {
        return view('admin.page_kuesioners.edit', [
            'halaman' => $page_kuesioner,
        ]);
    }


   public function update(Request $request, HalamanKuesioner $page_kuesioner)
        {
            $request->validate([
                'judul' => 'required|string|max:255',
                'deskripsi' => 'nullable|string',
                'urutan' => [
                    'required',
                    'integer',
                    'min:1',
                    Rule::unique('halaman_kuesioners', 'urutan')->ignore($page_kuesioner->id),
                ],
            ]);

            $page_kuesioner->update($request->only('judul', 'deskripsi', 'urutan'));

            return redirect()->route('admin.page_kuesioners.index')
                            ->with('success', 'Halaman berhasil diperbarui.');
        }
   
    public function destroy(HalamanKuesioner $page_kuesioner)
    {
        $page_kuesioner->delete();

        return redirect()->route('admin.page_kuesioners.index')
                         ->with('success', 'Halaman berhasil dihapus.');
    }
}
