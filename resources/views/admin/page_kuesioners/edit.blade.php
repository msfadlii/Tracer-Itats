{{-- resources/views/admin/page_kuesioners/edit.blade.php --}}
<x-app-layout>
  <x-slot name="header">
    <div class="mb-6 flex items-start gap-4 animate-fade-in">
      <div class="border-l-4 border-yellow-600 pl-4">
        <h2 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
          <i class="fas fa-edit text-yellow-600"></i>
          Edit Halaman Kuesioner
        </h2>
        <p class="text-sm text-gray-600 mt-1">
          Ubah data halaman kuesioner yang sudah ada.
        </p>
      </div>
    </div>
  </x-slot>

  <div class="py-8 bg-gray-50 min-h-screen text-gray-800">
    <div class="max-w-4xl mx-auto px-4">
      <div class="bg-white shadow rounded-xl p-6">
        
        {{-- Back Button --}}
        <div class="mb-6">
          <a href="{{ route('admin.page_kuesioners.index') }}" 
            class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition shadow-md">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Daftar Halaman
          </a>
        </div>

        {{-- Success Message --}}
        @if (session('success'))
          <div class="mb-4 p-4 bg-green-100 text-green-700 border border-green-300 rounded-md shadow-sm">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
          </div>
        @endif

        {{-- Current Page Info --}}
        <div class="mb-6 p-4 bg-yellow-50 rounded-lg border border-yellow-200">
          <h3 class="text-lg font-semibold text-yellow-800 mb-2">
            <i class="fas fa-file-alt mr-2"></i>
            Informasi Halaman Saat Ini
          </h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
              <p class="text-yellow-700"><strong>Judul:</strong> {{ $halaman->judul }}</p>
              <p class="text-yellow-700 mt-1"><strong>Urutan:</strong> {{ $halaman->urutan }}</p>
            </div>
          <div>
                <p class="text-yellow-700">
                    <strong>Dibuat:</strong>
                    {{ $halaman->created_at ? $halaman->created_at->format('d M Y H:i') : '-' }}
                </p>
                <p class="text-yellow-700 mt-1">
                    <strong>Terakhir Diubah:</strong>
                    {{ $halaman->updated_at ? $halaman->updated_at->format('d M Y H:i') : '-' }}
                </p>
            </div>

          </div>
          @if($halaman->deskripsi)
            <div class="mt-3">
              <p class="text-yellow-700"><strong>Deskripsi:</strong></p>
              <p class="text-yellow-600 mt-1">{{ $halaman->deskripsi }}</p>
            </div>
          @endif
        </div>

       {{-- resources/views/admin/page_kuesioners/edit.blade.php --}}
<form action="{{route('admin.page_kuesioners.update', $halaman) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="space-y-6">

        {{-- Judul Halaman --}}
        <div>
            <label for="judul" class="block text-sm font-medium text-gray-700 mb-2">
                Judul Halaman <span class="text-red-500">*</span>
            </label>
            <input type="text" name="judul" id="judul"
                value="{{ old('judul', $halaman->judul) }}" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm
                    focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                placeholder="Masukkan judul halaman...">
            @error('judul')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Deskripsi --}}
        <div>
            <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                Deskripsi Halaman
            </label>
            <textarea name="deskripsi" id="deskripsi" rows="4"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm
                    focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                placeholder="Masukkan deskripsi halaman (opsional)...">{{ old('deskripsi', $halaman->deskripsi) }}</textarea>
            @error('deskripsi')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Urutan --}}
        <div>
            <label for="urutan" class="block text-sm font-medium text-gray-700 mb-2">
                Urutan Halaman <span class="text-red-500">*</span>
            </label>
            <input type="number" name="urutan" id="urutan"
                value="{{ old('urutan', $halaman->urutan) }}" required min="1"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm
                    focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
            @error('urutan')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
            <p class="mt-1 text-sm text-gray-500">
                <i class="fas fa-info-circle mr-1"></i>
                Tentukan urutan tampilan halaman dalam kuesioner.
            </p>
        </div>

    </div>

    {{-- Tombol Aksi --}}
    <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
        <a href="{{ route('admin.page_kuesioners.index') }}"
            class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition shadow-md">
            Batal
        </a>
        <button type="submit"
            class="px-6 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg transition shadow-md">
            <i class="fas fa-save mr-2"></i>
            Simpan Perubahan
        </button>
    </div>
</form>


        {{-- Related Questions Section --}}
        @if($halaman->pertanyaans && $halaman->pertanyaans->count() > 0)
          <div class="mt-8 p-4 bg-blue-50 rounded-lg border border-blue-200">
            <h4 class="text-sm font-medium text-blue-800 mb-3">
              <i class="fas fa-question-circle mr-2"></i>
              Pertanyaan di Halaman Ini ({{ $halaman->pertanyaans->count() }})
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
              @foreach($halaman->pertanyaans->take(6) as $pertanyaan)
                <div class="bg-white px-3 py-2 rounded border text-sm">
                  {{ Str::limit($pertanyaan->teks, 60) }}
                </div>
              @endforeach
              @if($halaman->pertanyaans->count() > 6)
                <div class="bg-white px-3 py-2 rounded border text-sm text-gray-500 italic">
                  dan {{ $halaman->pertanyaans->count() - 6 }} pertanyaan lainnya...
                </div>
              @endif
            </div>
          </div>
        @endif

        {{-- Warning Note --}}
        <div class="mt-6 p-4 bg-amber-50 border-l-4 border-amber-400">
          <div class="flex">
            <div class="flex-shrink-0">
              <i class="fas fa-exclamation-triangle text-amber-400"></i>
            </div>
            <div class="ml-3">
              <p class="text-sm text-amber-700">
                <strong>Perhatian:</strong> Mengubah urutan halaman dapat mempengaruhi alur kuesioner. 
                Pastikan urutan yang baru masih logis untuk responden.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>