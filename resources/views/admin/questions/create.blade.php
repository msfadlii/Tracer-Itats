<x-app-layout>
  <x-slot name="header">
    <div class="mb-6 flex items-start gap-4 animate-fade-in">
      <div class="border-l-4 border-green-600 pl-4">
        <h2 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
          <i class="fas fa-plus-circle text-green-600"></i>
          Tambah Pertanyaan Baru
        </h2>
        <p class="text-sm text-gray-600 mt-1">
          Buat pertanyaan baru untuk kuesioner sistem.
        </p>
      </div>
    </div>
  </x-slot>

  <div class="py-8 bg-gray-50 min-h-screen text-gray-800">
    <div class="max-w-4xl mx-auto px-4">
      <div class="bg-white shadow rounded-xl p-6">
        
        <!-- Debug Info (hapus setelah masalah teratasi) -->
        @if(config('app.debug'))
          <div class="mb-4 p-3 bg-yellow-100 border border-yellow-300 rounded">
            <p class="text-sm text-yellow-800">
              <strong>Info:</strong> Jumlah halaman kuesioner: {{ $halamanKuesioners->count() }}
            </p>
            @if($halamanKuesioners->isEmpty())
              <p class="text-sm text-red-600 mt-1">
                ⚠️ Tidak ada data halaman kuesioner! Pastikan tabel halaman_kuesioners memiliki data.
              </p>
            @endif
          </div>
        @endif
        
        <div class="mb-6">
          <a href="{{ route('admin.questions.index') }}" 
            class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition shadow-md">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Daftar
          </a>
        </div>

        {{-- Form --}}
        <form action="{{ route('admin.questions.store') }}" method="POST" id="questionForm">
          @csrf
          
          {{-- informasi --}}
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="md:col-span-2">
              <label for="teks" class="block text-sm font-medium text-gray-700 mb-2">
                Teks Pertanyaan <span class="text-red-500">*</span>
              </label>
              <textarea name="teks" id="teks" rows="3" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                placeholder="Masukkan teks pertanyaan...">{{ old('teks') }}</textarea>
              @error('teks')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="jenis_pertanyaan_id" class="block text-sm font-medium text-gray-700 mb-2">
                Jenis Pertanyaan <span class="text-red-500">*</span>
              </label>
              <select name="jenis_pertanyaan_id" id="jenis_pertanyaan_id" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">Pilih Jenis Pertanyaan</option>
                @foreach($questionTypes as $type)
                  <option value="{{ $type->id }}" data-name="{{ $type->nama }}" {{ old('jenis_pertanyaan_id') == $type->id ? 'selected' : '' }}>
                    {{ ucfirst($type->nama) }}
                  </option>
                @endforeach
              </select>
              @error('jenis_pertanyaan_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="halaman_kuesioner_id" class="block text-sm font-medium text-gray-700 mb-2">
                Halaman Kuesioner <span class="text-red-500">*</span>
              </label>
              <select name="halaman_kuesioner_id" id="halaman_kuesioner_id" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">Pilih Halaman</option>
               @forelse($halamanKuesioners as $halaman)
                <option value="{{ $halaman->id }}" {{ old('halaman_kuesioner_id') == $halaman->id ? 'selected' : '' }}>
                    {{ $loop->iteration }}. {{ $halaman->judul ?? 'Halaman ID: ' . $halaman->id }}
                </option>
                @empty
                <option value="" disabled>Tidak ada halaman kuesioner tersedia</option>
                @endforelse
              </select>
              @error('halaman_kuesioner_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="urutan" class="block text-sm font-medium text-gray-700 mb-2">
                Urutan Pertanyaan <span class="text-red-500">*</span>
              </label>
              <input type="number" name="urutan" id="urutan" value="{{ old('urutan', 1) }}" 
                min="1" step="1"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                placeholder="Masukkan urutan (minimal 1)">
              @error('urutan')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
              <p class="mt-1 text-xs text-gray-500">
                Urutan pertanyaan dalam halaman (minimal 1)
              </p>
            </div>

            <div class="space-y-4">
                {{-- Baris atas: Wajib --}}
                <div class="flex items-center">
                    <input type="checkbox" name="wajib" id="wajib" value="1" {{ old('wajib') ? 'checked' : '' }}
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="wajib" class="ml-2 block text-sm text-gray-700">
                        Pertanyaan Wajib
                    </label>
                </div>

                {{-- Container untuk Opsi Lainnya (akan ditampilkan hanya untuk radio dan checkbox) --}}
                <div id="opsi-lainnya-container" class="hidden">
                    <div class="flex items-center">
                        <input type="checkbox" name="punya_opsi_lain" id="punya_opsi_lain" value="1" {{ old('punya_opsi_lain') ? 'checked' : '' }}
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="punya_opsi_lain" class="ml-2 block text-sm text-gray-700">
                            Punya Opsi "Lainnya"
                        </label>
                    </div>
                </div>

                {{-- Visualisasi --}}
                <div class="flex items-center">
                    <input type="checkbox" name="visualisasi" id="visualisasi" value="1" {{ old('visualisasi') ? 'checked' : '' }}
                        class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                    <label for="visualisasi" class="ml-2 block text-sm text-gray-700">
                        Tampilkan dalam Visualisasi
                    </label>
                </div>
            </div>

        </div>

          {{-- Options Section (for select, radio, checkbox) --}}
          <div id="options-section" class="mb-6 hidden">
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Opsi Jawaban
            </label>
            <div id="options-container">
              <div class="flex items-center gap-2 mb-2 option-row">
                <input type="text" name="opsi[]" placeholder="Opsi jawaban..."
                  class="flex-1 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <button type="button" class="px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg remove-option">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <button type="button" id="add-option" class="mt-2 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg">
              + Tambah Opsi
            </button>
          </div>

          {{-- Scale Section --}}
          <div id="scale-section" class="mb-6 hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label for="skala_range" class="block text-sm font-medium text-gray-700 mb-2">
                  Range Skala (contoh: 1-5)
                </label>
                <input type="text" name="skala_range" id="skala_range" placeholder="1-5"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
              </div>
              <div>
                <label for="skala_labels" class="block text-sm font-medium text-gray-700 mb-2">
                  Label Skala (pisahkan dengan koma)
                </label>
                <input type="text" name="skala_labels" id="skala_labels" placeholder="(Sangat Buruk,Sangat Baik)"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
              </div>
            </div>
            <div id="scale-hint" class="p-4 bg-yellow-100 border-yellow-400 border rounded text-sm text-gray-500 mt-2 hidden">
               <strong> Contoh Menggunakan Skala: </strong>
                <br>
                • <strong>Range:</strong> 1-5 <br>
                • <strong>Label ujung:</strong> "Sangat Tidak Puas", "Sangat Puas" <br>
                Hanya dua label yang digunakan untuk menunjukkan range sisi kiri dan kanan.
                </div>
          </div>

          {{-- Matrix Section --}}
          <div id="matrix-section" class="mb-6 hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Baris Matrix
                </label>
                <div id="matrix-rows-container">
                  <div class="flex items-center gap-2 mb-2 matrix-row">
                    <input type="text" name="matrix_rows[]" placeholder="Label baris..."
                      class="flex-1 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <button type="button" class="px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg remove-matrix-row">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <button type="button" id="add-matrix-row" class="mt-2 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg">
                  + Tambah Baris
                </button>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Kolom Matrix
                </label>
                <div id="matrix-columns-container">
                  <div class="flex items-center gap-2 mb-2 matrix-column">
                    <input type="text" name="matrix_columns[]" placeholder="Label kolom..."
                      class="flex-1 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <button type="button" class="px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg remove-matrix-column">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <button type="button" id="add-matrix-column" class="mt-2 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg">
                  + Tambah Kolom
                </button>
              </div>
            </div>
          </div>

          {{-- Employment Conditions --}}
          <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Kondisi Tampil Berdasarkan Status Kerja
            </label>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
              @foreach($statusList as $status)
                <div class="flex items-center">
                  <input type="checkbox" name="employment_conditions[]" value="{{ $status }}"
                    id="employment_{{ $loop->index }}"
                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                  <label for="employment_{{ $loop->index }}" class="ml-2 block text-sm text-gray-700">
                    {{ $status }}
                  </label>
                </div>
              @endforeach
            </div>
          </div>

          {{-- Submit Buttons --}}
          <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.questions.index') }}"
              class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition shadow-md">
              Batal
            </a>
            <button type="submit"
              class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition shadow-md">
              Simpan Pertanyaan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

 <script>
  document.addEventListener('DOMContentLoaded', function() {
    const questionTypeSelect = document.getElementById('jenis_pertanyaan_id');
    const optionsSection = document.getElementById('options-section');
    const scaleSection = document.getElementById('scale-section');
    const matrixSection = document.getElementById('matrix-section');
    const opsiLainnyaContainer = document.getElementById('opsi-lainnya-container');
    const urutanInput = document.getElementById('urutan');
    document.getElementById('scale-hint').classList.add('hidden');

    urutanInput.addEventListener('input', function() {
      let value = parseInt(this.value);
    //isNan(value) adalah fungsi untuk mengecek apakah value adalah angka atau bukan
      if (value < 1 || isNaN(value)) {
        this.value = 1;
      }
    });

    document.getElementById('questionForm').addEventListener('submit', function(e) {
      const urutanValue = parseInt(urutanInput.value);
      if (urutanValue < 1 || isNaN(urutanValue)) {
        e.preventDefault();
        alert('Urutan harus berupa angka positif (minimal 1)');
        urutanInput.focus();
        return false;
      }
    });

    questionTypeSelect.addEventListener('change', function() {
      const selectedOption = this.options[this.selectedIndex];
      const typeName = selectedOption.getAttribute('data-name');
      
      optionsSection.classList.add('hidden');
      scaleSection.classList.add('hidden');
      matrixSection.classList.add('hidden');
      opsiLainnyaContainer.classList.add('hidden');

      document.getElementById('punya_opsi_lain').checked = false;

      if (['select', 'radio', 'checkbox'].includes(typeName)) {
        optionsSection.classList.remove('hidden');
        
        if (['radio', 'checkbox'].includes(typeName)) {
          opsiLainnyaContainer.classList.remove('hidden');
        }
      } else if (typeName === 'scale') {
        scaleSection.classList.remove('hidden');
        document.getElementById('scale-hint').classList.remove('hidden');
        } else if (typeName === 'matrix') {
        matrixSection.classList.remove('hidden');
      }
    });

    // Menambahkan opsi jawaban
    document.getElementById('add-option').addEventListener('click', function() {
      const container = document.getElementById('options-container');
      const newRow = document.createElement('div');
      newRow.className = 'flex items-center gap-2 mb-2 option-row';
      newRow.innerHTML = `
        <input type="text" name="opsi[]" placeholder="Opsi jawaban..."
          class="flex-1 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        <button type="button" class="px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg remove-option">
          <i class="fas fa-times"></i>
        </button>
      `;
      container.appendChild(newRow);
    });

    // Menghapus opsi jawaban
    document.addEventListener('click', function(e) {
      if (e.target.closest('.remove-option')) {
        e.target.closest('.option-row').remove();
      }
    });

    // Menambahkan baris matrix
    document.getElementById('add-matrix-row').addEventListener('click', function() {
      const container = document.getElementById('matrix-rows-container');
      const newRow = document.createElement('div');
      newRow.className = 'flex items-center gap-2 mb-2 matrix-row';
      newRow.innerHTML = `
        <input type="text" name="matrix_rows[]" placeholder="Label baris..."
          class="flex-1 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        <button type="button" class="px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg remove-matrix-row">
          <i class="fas fa-times"></i>
        </button>
      `;
      container.appendChild(newRow);
    });

    // Menghapus baris matrix
    document.addEventListener('click', function(e) {
      if (e.target.closest('.remove-matrix-row')) {
        e.target.closest('.matrix-row').remove();
      }
    });

    // Menambahkan kolom matrix
    document.getElementById('add-matrix-column').addEventListener('click', function() {
      const container = document.getElementById('matrix-columns-container');
      const newRow = document.createElement('div');
      newRow.className = 'flex items-center gap-2 mb-2 matrix-column';
      newRow.innerHTML = `
        <input type="text" name="matrix_columns[]" placeholder="Label kolom..."
          class="flex-1 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        <button type="button" class="px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg remove-matrix-column">
          <i class="fas fa-times"></i>
        </button>
      `;
      container.appendChild(newRow);
    });

    // Menghapus kolom matrix
    document.addEventListener('click', function(e) {
      if (e.target.closest('.remove-matrix-column')) {
        e.target.closest('.matrix-column').remove();
      }
    });
  });

</script>

</x-app-layout>