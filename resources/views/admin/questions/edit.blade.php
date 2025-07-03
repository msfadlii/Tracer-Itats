{{-- Layout --}}
<x-app-layout>
  <x-slot name="header">
    <div class="mb-6 flex items-start gap-4 animate-fade-in">
      <div class="border-l-4 border-gradient-to-r from-blue-500 to-purple-600 pl-4">
        <h2 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent flex items-center gap-2">
          <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center shadow-lg">
            <i class="fas fa-edit text-white text-lg"></i>
          </div>
          Edit Pertanyaan
        </h2>
        <p class="text-sm text-gray-600 mt-2 ml-12">Ubah data pertanyaan yang sudah ada dengan mudah dan cepat.</p>
      </div>
    </div>
  </x-slot>

  <div class="py-8 bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen text-gray-800">
    <div class="max-w-4xl mx-auto px-4">
      <div class="bg-white shadow-2xl rounded-2xl p-8 border border-gray-100 backdrop-blur-sm">

        {{-- Tombol Kembali dengan Hover Effect --}}
        <div class="mb-8">
          <a href="{{ route('admin.questions.index') }}"
             class="group inline-flex items-center px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
            <i class="fas fa-arrow-left mr-2 transition-transform group-hover:-translate-x-1"></i> 
            Kembali ke Daftar
          </a>
        </div>

        {{-- Pesan Sukses dengan Animation --}}
        @if(session('success'))
          <div class="mb-6 p-4 bg-gradient-to-r from-green-50 to-emerald-50 text-green-700 border border-green-200 rounded-xl shadow-sm animate-pulse">
            <div class="flex items-center">
              <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center mr-3">
                <i class="fas fa-check text-white text-xs"></i>
              </div>
              {{ session('success') }}
            </div>
          </div>
        @endif

        {{-- FORM dengan Card Design --}}
        <form action="{{ route('admin.questions.update', $question->id) }}" method="POST" id="questionForm" class="space-y-8">
          @csrf @method('PUT')

          {{-- Section 1: Informasi Dasar --}}
          <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-100">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
              <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                <i class="fas fa-info-circle text-white text-sm"></i>
              </div>
              Informasi Dasar
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="md:col-span-2">
                <label for="teks" class="block text-sm font-medium text-gray-700 mb-2">
                  Teks Pertanyaan <span class="text-red-500">*</span>
                </label>
                <textarea name="teks" id="teks" rows="4" required
                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-blue-300"
                  placeholder="Masukkan teks pertanyaan dengan jelas dan mudah dipahami...">{{ old('teks', $question->teks) }}</textarea>
                @error('teks')<p class="mt-2 text-sm text-red-600 flex items-center"><i class="fas fa-exclamation-triangle mr-1"></i>{{ $message }}</p>@enderror
              </div>

              {{-- Jenis Pertanyaan dengan Badge --}}
              <div>
                <label for="jenis_pertanyaan_id" class="block text-sm font-medium text-gray-700 mb-2">
                  Jenis Pertanyaan <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                  <select name="jenis_pertanyaan_disabled" id="jenis_pertanyaan_id" disabled
                          class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl bg-gradient-to-r from-gray-50 to-gray-100 cursor-not-allowed">
                    <option value="">Pilih Jenis Pertanyaan</option>
                    @foreach($questionTypes as $type)
                      <option value="{{ $type->id }}" data-name="{{ $type->nama }}"
                              {{ $question->jenis_pertanyaan_id == $type->id ? 'selected' : '' }}>
                        {{ ucfirst($type->nama) }}
                      </option>
                    @endforeach
                  </select>
                  <div class="absolute top-1/2 right-4 transform -translate-y-1/2">
                    <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">Terkunci</span>
                  </div>
                </div>
                <input type="hidden" name="jenis_pertanyaan_id" value="{{ $question->jenis_pertanyaan_id }}">
              </div>

              {{-- Halaman --}}
              <div>
                <label for="halaman_kuesioner_id" class="block text-sm font-medium text-gray-700 mb-2">
                  Halaman Kuesioner <span class="text-red-500">*</span>
                </label>
                <select name="halaman_kuesioner_id" id="halaman_kuesioner_id" required 
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                  <option value="">Pilih Halaman</option>
                  @foreach($halamanKuesioners as $halaman)
                    <option value="{{ $halaman->id }}"
                      {{ old('halaman_kuesioner_id', $question->halaman_kuesioner_id) == $halaman->id ? 'selected' : '' }}>
                      {{ $halaman->judul ?? 'Halaman ID: ' . $halaman->id }}
                    </option>
                  @endforeach
                </select>
                @error('halaman_kuesioner_id')<p class="mt-2 text-sm text-red-600 flex items-center"><i class="fas fa-exclamation-triangle mr-1"></i>{{ $message }}</p>@enderror
              </div>

              {{-- Urutan --}}
              <div class="md:col-span-2">
                <label for="urutan" class="block text-sm font-medium text-gray-700 mb-2">
                  Urutan Pertanyaan
                </label>
                <input type="number" name="urutan" id="urutan" min="1" step="1"
                  value="{{ old('urutan', $question->urutan) }}"
                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                @error('urutan')<p class="mt-2 text-sm text-red-600 flex items-center"><i class="fas fa-exclamation-triangle mr-1"></i>{{ $message }}</p>@enderror
              </div>
            </div>
          </div>

          {{-- Section 2: Pengaturan Pertanyaan --}}
          <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl p-6 border border-purple-100">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
              <div class="w-8 h-8 bg-purple-500 rounded-lg flex items-center justify-center mr-3">
                <i class="fas fa-cog text-white text-sm"></i>
              </div>
              Pengaturan Pertanyaan
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
              <div class="bg-white rounded-lg p-4 border border-gray-100 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center">
                  <input type="checkbox" name="wajib" id="wajib" value="1"
                         {{ old('wajib', $question->wajib) ? 'checked' : '' }}
                         class="h-5 w-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                  <label for="wajib" class="ml-3 text-sm font-medium text-gray-700 flex items-center">
                    <i class="fas fa-asterisk text-red-500 text-xs mr-1"></i>
                    Pertanyaan Wajib
                  </label>
                </div>
              </div>

              <div id="opsi-lainnya-container" class="bg-white rounded-lg p-4 border border-gray-100 hover:shadow-md transition-shadow duration-200 hidden">
                <div class="flex items-center">
                  <input type="checkbox" name="punya_opsi_lain" id="punya_opsi_lain" value="1"
                         {{ old('punya_opsi_lain', $question->punya_opsi_lain) ? 'checked' : '' }}
                         class="h-5 w-5 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                  <label for="punya_opsi_lain" class="ml-3 text-sm font-medium text-gray-700 flex items-center">
                    <i class="fas fa-plus-circle text-purple-500 text-xs mr-1"></i>
                    Opsi "Lainnya"
                  </label>
                </div>
              </div>

              <div class="bg-white rounded-lg p-4 border border-gray-100 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center">
                  <input type="checkbox" name="visualisasi" id="visualisasi" value="1"
                         {{ old('visualisasi', $question->visualisasi) ? 'checked' : '' }}
                         class="h-5 w-5 text-green-600 border-gray-300 rounded focus:ring-green-500">
                  <label for="visualisasi" class="ml-3 text-sm font-medium text-gray-700 flex items-center">
                    <i class="fas fa-chart-bar text-green-500 text-xs mr-1"></i>
                    Tampilkan Grafik
                  </label>
                </div>
              </div>
            </div>
          </div>

          {{-- Dynamic Sections --}}
          {{-- Opsi Jawaban Section --}}
          <div id="options-section" class="bg-gradient-to-r from-green-50 to-teal-50 rounded-xl p-6 border border-green-100 hidden">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
              <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                <i class="fas fa-list text-white text-sm"></i>
              </div>
              Edit Opsi Jawaban
            </h3>
            <div class="space-y-3">
              @foreach($question->opsiJawabans as $i => $opsi)
                <div class="flex items-center gap-3 bg-white rounded-lg p-3 border border-gray-100 hover:shadow-sm transition-shadow duration-200">
                  <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                    <span class="text-sm font-medium text-green-600">{{ $i + 1 }}</span>
                  </div>
                  <input type="text" name="opsi[]" value="{{ old("opsi.$i", $opsi->teks) }}"
                         class="flex-1 px-4 py-2 border border-gray-200 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500"
                         placeholder="Edit teks opsi">
                  <input type="hidden" name="opsi_ids[]" value="{{ $opsi->id }}">
                  <input type="hidden" name="urutan_opsi[]" value="{{ $opsi->urutan }}">
                </div>
              @endforeach
            </div>
          </div>

          {{-- Scale Section --}}
          <div id="scale-section" class="bg-gradient-to-r from-orange-50 to-red-50 rounded-xl p-6 border border-orange-100 hidden">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
              <div class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center mr-3">
                <i class="fas fa-ruler text-white text-sm"></i>
              </div>
              Pengaturan Skala
            </h3>
            <div class="space-y-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Range Skala (Terkunci)</label>
                <input type="text" name="skala_range" id="skala_range"
                       value="{{ old('skala_range', implode(' - ', $atributEkstra['range'] ?? [])) }}"
                       class="w-full px-4 py-3 border-2 border-orange-200 bg-gradient-to-r from-orange-50 to-red-50 cursor-not-allowed rounded-xl" readonly>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Label Skala (Bisa Diubah)</label>
                <div id="skala-labels-container" class="space-y-2">
                  @php $labels = old('skala_labels', $atributEkstra['labels'] ?? []); @endphp
                  @foreach($labels as $i => $label)
                    <div class="flex items-center gap-3 bg-white rounded-lg p-3 border border-gray-100">
                      <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center">
                        <span class="text-sm font-medium text-orange-600">{{ $i + 1 }}</span>
                      </div>
                      <input type="text" name="skala_labels[]" value="{{ $label }}"
                            class="flex-1 px-4 py-2 border border-gray-200 rounded-lg shadow-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500" 
                            placeholder="Label skala...">
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
          </div>

          {{-- Matrix Section --}}
          <div id="matrix-section" class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl p-6 border border-indigo-100 hidden">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
              <div class="w-8 h-8 bg-indigo-500 rounded-lg flex items-center justify-center mr-3">
                <i class="fas fa-table text-white text-sm"></i>
              </div>
              Pengaturan Matrix
            </h3>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">Baris Matrix</label>
                <div id="matrix-rows-container" class="space-y-2">
                  @foreach($question->barisMatrixs as $i => $baris)
                    <div class="flex items-center gap-3 bg-white rounded-lg p-3 border border-gray-100 matrix-row">
                      <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                        <span class="text-sm font-medium text-indigo-600">{{ $i + 1 }}</span>
                      </div>
                      <input type="text" name="matrix_rows[]" value="{{ old("matrix_rows.$i", $baris->label) }}"
                             class="flex-1 px-4 py-2 border border-gray-200 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                      <input type="hidden" name="matrix_row_ids[]" value="{{ $baris->id }}">
                    </div>
                  @endforeach
                </div>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">Kolom Matrix</label>
                <div id="matrix-columns-container" class="space-y-2">
                  @foreach(old('matrix_columns', $atributEkstra['columns'] ?? []) as $col)
                    <div class="flex items-center gap-3 bg-white rounded-lg p-3 border border-gray-100 matrix-column">
                      <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-columns text-purple-600 text-xs"></i>
                      </div>
                      <input type="text" name="matrix_columns[]" value="{{ $col }}"
                             class="flex-1 px-4 py-2 border border-gray-200 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
          </div>

          {{-- Kondisi Kerja Section --}}
          <div class="bg-gradient-to-r from-teal-50 to-cyan-50 rounded-xl p-6 border border-teal-100">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
              <div class="w-8 h-8 bg-teal-500 rounded-lg flex items-center justify-center mr-3">
                <i class="fas fa-briefcase text-white text-sm"></i>
              </div>
              Kondisi Tampil Berdasarkan Status Kerja
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
              @foreach($statusList as $idx => $status)
                <div class="bg-white rounded-lg p-3 border border-gray-100 hover:shadow-sm transition-shadow duration-200">
                  <div class="flex items-center">
                    <input type="checkbox" name="employment_conditions[]" id="employment_{{ $idx }}" value="{{ $status }}"
                      {{ in_array($status, old('employment_conditions', $selectedConditions)) ? 'checked' : '' }}
                      class="h-4 w-4 text-teal-600 border-gray-300 rounded focus:ring-teal-500">
                    <label for="employment_{{ $idx }}" class="ml-3 text-sm text-gray-700">{{ $status }}</label>
                  </div>
                </div>
              @endforeach
            </div>
          </div>

          {{-- Action Buttons --}}
          <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
            <a href="{{ route('admin.questions.index') }}" 
               class="px-8 py-3 bg-gradient-to-r from-gray-400 to-gray-500 hover:from-gray-500 hover:to-gray-600 text-white rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
              Batal
            </a>
            <button type="submit" 
                    class="px-8 py-3 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center">
              <i class="fas fa-save mr-2"></i>
              Update Pertanyaan
            </button>
          </div>

          {{-- Enhanced Warning --}}
          <div class="mt-8 bg-gradient-to-r from-yellow-50 to-amber-50 border-l-4 border-yellow-400 rounded-xl p-6 shadow-sm">
            <div class="flex items-start">
              <div class="w-10 h-10 bg-yellow-400 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                <i class="fas fa-exclamation-triangle text-white"></i>
              </div>
              <div>
                <h4 class="text-lg font-semibold text-yellow-800 mb-2">Penting untuk Diperhatikan</h4>
                <p class="text-sm text-yellow-700 leading-relaxed">
                  Anda hanya dapat <span class="font-semibold">mengedit teks pertanyaan dan atribut umum</span>.<br>
                  Untuk mengubah <em>opsi jawaban, skala, atau matrix</em>, silakan hapus pertanyaan dan buat yang baru.
                </p>
              </div>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>

 <script>document.addEventListener('DOMContentLoaded', function () {
  const jenisSelect = document.getElementById('jenis_pertanyaan_id');
  const optionsSection = document.getElementById('options-section');
  const scaleSection = document.getElementById('scale-section');
  const matrixSection = document.getElementById('matrix-section');
  const opsiLainnya = document.getElementById('opsi-lainnya-container');

  const toggleSections = type => {
    // Hide all sections with smooth transition
    [optionsSection, scaleSection, matrixSection].forEach(el => {
      if (el) {
        el.style.opacity = '0';
        el.style.transform = 'translateY(-10px)';
        setTimeout(() => el.classList.add('hidden'), 200);
      }
    });

    // Handle opsi lainnya separately - show/hide based on question type
    if (opsiLainnya) {
      if (['radio', 'checkbox'].includes(type)) {
        // Show opsi lainnya for all option-based questions
        opsiLainnya.classList.remove('hidden');
        opsiLainnya.style.opacity = '1';
        opsiLainnya.style.transform = 'translateY(0)';
      } else {
        // Hide opsi lainnya for non-option questions (scale, matrix, text, etc.)
        opsiLainnya.style.opacity = '0';
        opsiLainnya.style.transform = 'translateY(-10px)';
        setTimeout(() => opsiLainnya.classList.add('hidden'), 200);
      }
    }

    // Show relevant section with animation
    setTimeout(() => {
      let targetSection = null;
      
      if (['select', 'radio', 'checkbox'].includes(type)) {
        targetSection = optionsSection;
      } else if (type === 'scale') {
        targetSection = scaleSection;
      } else if (type === 'matrix') {
        targetSection = matrixSection;
      }

      if (targetSection) {
        targetSection.classList.remove('hidden');
        targetSection.style.opacity = '0';
        targetSection.style.transform = 'translateY(-10px)';
        
        requestAnimationFrame(() => {
          targetSection.style.transition = 'all 0.3s ease-out';
          targetSection.style.opacity = '1';
          targetSection.style.transform = 'translateY(0)';
        });
      }
    }, 250);
  };

  if (jenisSelect) {
    const selectedType = jenisSelect.options[jenisSelect.selectedIndex]?.dataset.name;
    toggleSections(selectedType);
    
    jenisSelect.addEventListener('change', () => {
      const type = jenisSelect.options[jenisSelect.selectedIndex]?.dataset.name;
      toggleSections(type);
    });
  }

  // Add form validation feedback
  const form = document.getElementById('questionForm');
  form.addEventListener('submit', function(e) {
    const submitBtn = form.querySelector('button[type="submit"]');
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
    submitBtn.disabled = true;
  });

  // Add hover effects to input fields
  const inputs = document.querySelectorAll('input, textarea, select');
  inputs.forEach(input => {
    input.addEventListener('focus', function() {
      this.parentElement.style.transform = 'translateY(-1px)';
    });
    
    input.addEventListener('blur', function() {
      this.parentElement.style.transform = 'translateY(0)';
    });
  });
});</script>

</x-app-layout>