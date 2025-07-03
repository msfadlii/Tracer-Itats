<x-app-layout>
  <x-slot name="header">
    <div class="mb-6 flex items-start gap-4 animate-fade-in">
      <div class="border-l-4 border-green-600 pl-4">
        <h2 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
          <i class="fas fa-plus-circle text-green-600"></i>
          Tambah Kuesioner Baru
        </h2>
        <p class="text-sm text-gray-600 mt-1">
          Buat kuesioner baru untuk mengumpulkan data dan feedback.
        </p>
      </div>
    </div>
  </x-slot>

  <div class="py-8 bg-gray-50 min-h-screen text-gray-800">
    <div class="max-w-4xl mx-auto px-4">
      <div class="bg-white shadow rounded-xl p-6">
        
        {{-- Back Button --}}
        <div class="mb-6">
          <a href="{{ route('admin.kuesioners.index') }}" 
            class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition shadow-md">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Daftar
          </a>
        </div>

        {{-- Success Message --}}
        @if (session('success'))
          <div class="mb-4 p-4 bg-green-100 text-green-700 border border-green-300 rounded-md shadow-sm">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
          </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('admin.kuesioners.store') }}" method="POST">
          @csrf
          
          {{-- Form Header --}}
          <div class="mb-6 p-4 bg-green-50 rounded-lg border-l-4 border-green-500">
            <h3 class="text-lg font-semibold text-gray-800 mb-2 flex items-center gap-2">
              <i class="fas fa-clipboard-list text-green-600"></i>
              Informasi Kuesioner
            </h3>
            <p class="text-sm text-gray-600">
              Masukkan nama kuesioner yang akan dibuat. Pastikan nama yang dipilih jelas dan mudah dipahami.
            </p>
          </div>

          {{-- Form Fields --}}
          <div class="mb-6">
            <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
              Nama Kuesioner <span class="text-red-500">*</span>
            </label>
            <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required
              class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
              placeholder="Contoh: Survei Kepuasan Pelanggan 2025">
            @error('nama')
              <p class="mt-2 text-sm text-red-600 flex items-center">
                <i class="fas fa-exclamation-circle mr-1"></i>
                {{ $message }}
              </p>
            @enderror
            
            {{-- Helper Text --}}
            <p class="mt-2 text-sm text-gray-500">
              <i class="fas fa-info-circle mr-1"></i>
              Nama kuesioner akan ditampilkan sebagai judul utama pada form
            </p>
          </div>

          {{-- Preview Card --}}
          <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
            <h4 class="text-sm font-medium text-blue-800 mb-3 flex items-center gap-2">
              <i class="fas fa-eye text-blue-600"></i>
              Preview Tampilan
            </h4>
            <div class="bg-white rounded-lg border border-blue-200 overflow-hidden">
              <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-4 text-white">
                <h5 id="preview-title" class="text-lg font-bold">
                  {{ old('nama') ?: 'Nama Kuesioner Anda' }}
                </h5>
                <p class="text-blue-100 text-sm mt-1">
                  <i class="fas fa-info-circle mr-1"></i>
                  Silakan lengkapi kuesioner berikut dengan jujur dan sesuai dengan kondisi Anda.
                </p>
              </div>
              <div class="p-4 bg-gray-50">
                <div class="text-sm text-gray-600 flex items-center">
                  <i class="fas fa-calendar mr-2"></i>
                  Dibuat pada: {{ now()->format('d M Y') }}
                </div>
              </div>
            </div>
          </div>

          {{-- Submit Buttons --}}
          <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.kuesioners.index') }}"
              class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition shadow-md">
              Batal
            </a>
            <button type="submit"
              class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition shadow-md">
              <i class="fas fa-save mr-2"></i>
              Simpan Kuesioner
            </button>
          </div>
          
          {{-- Info Note --}}
          <div class="mt-6 p-4 bg-yellow-50 border-l-4 border-yellow-400">
            <div class="flex">
              <div class="flex-shrink-0">
                <i class="fas fa-lightbulb text-yellow-400"></i>
              </div>
              <div class="ml-3">
                <p class="text-sm text-yellow-700">
                  <strong>Tips:</strong> Setelah kuesioner dibuat, Anda dapat menambahkan pertanyaan, 
                  mengatur halaman, dan menyesuaikan tampilan melalui menu pengelolaan pertanyaan.
                </p>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  {{-- JavaScript for live preview --}}
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const namaInput = document.getElementById('nama');
      const previewTitle = document.getElementById('preview-title');
      
      if (namaInput && previewTitle) {
        namaInput.addEventListener('input', function() {
          const value = this.value.trim();
          previewTitle.textContent = value || 'Nama Kuesioner Anda';
        });
      }
    });
  </script>

  {{-- Custom CSS for animations --}}
  <style>
    .animate-fade-in {
      animation: fadeInUp 0.6s ease-out;
    }
    
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</x-app-layout><x-app-layout>
  <x-slot name="header">
    <div class="mb-6 flex items-start gap-4 animate-fade-in">
      <div class="border-l-4 border-green-600 pl-4">
        <h2 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
          <i class="fas fa-plus-circle text-green-600"></i>
          Tambah Kuesioner Baru
        </h2>
        <p class="text-sm text-gray-600 mt-1">
          Buat kuesioner baru untuk mengumpulkan data dan feedback.
        </p>
      </div>
    </div>
  </x-slot>

  <div class="py-8 bg-gray-50 min-h-screen text-gray-800">
    <div class="max-w-4xl mx-auto px-4">
      <div class="bg-white shadow rounded-xl p-6">
        
        {{-- Back Button --}}
        <div class="mb-6">
          <a href="{{ route('admin.kuesioners.index') }}" 
            class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition shadow-md">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Daftar
          </a>
        </div>

        {{-- Success Message --}}
        @if (session('success'))
          <div class="mb-4 p-4 bg-green-100 text-green-700 border border-green-300 rounded-md shadow-sm">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
          </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('admin.kuesioners.store') }}" method="POST">
          @csrf
          
          {{-- Form Header --}}
          <div class="mb-6 p-4 bg-green-50 rounded-lg border-l-4 border-green-500">
            <h3 class="text-lg font-semibold text-gray-800 mb-2 flex items-center gap-2">
              <i class="fas fa-clipboard-list text-green-600"></i>
              Informasi Kuesioner
            </h3>
            <p class="text-sm text-gray-600">
              Masukkan nama kuesioner yang akan dibuat. Pastikan nama yang dipilih jelas dan mudah dipahami.
            </p>
          </div>

          {{-- Form Fields --}}
          <div class="mb-6">
            <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
              Nama Kuesioner <span class="text-red-500">*</span>
            </label>
            <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required
              class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
              placeholder="Contoh: Survei Kepuasan Pelanggan 2025">
            @error('nama')
              <p class="mt-2 text-sm text-red-600 flex items-center">
                <i class="fas fa-exclamation-circle mr-1"></i>
                {{ $message }}
              </p>
            @enderror
            
            {{-- Helper Text --}}
            <p class="mt-2 text-sm text-gray-500">
              <i class="fas fa-info-circle mr-1"></i>
              Nama kuesioner akan ditampilkan sebagai judul utama pada form
            </p>
          </div>

          {{-- Preview Card --}}
          <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
            <h4 class="text-sm font-medium text-blue-800 mb-3 flex items-center gap-2">
              <i class="fas fa-eye text-blue-600"></i>
              Preview Tampilan
            </h4>
            <div class="bg-white rounded-lg border border-blue-200 overflow-hidden">
              <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-4 text-white">
                <h5 id="preview-title" class="text-lg font-bold">
                  {{ old('nama') ?: 'Nama Kuesioner Anda' }}
                </h5>
                <p class="text-blue-100 text-sm mt-1">
                  <i class="fas fa-info-circle mr-1"></i>
                  Silakan lengkapi kuesioner berikut dengan jujur dan sesuai dengan kondisi Anda.
                </p>
              </div>
              <div class="p-4 bg-gray-50">
                <div class="text-sm text-gray-600 flex items-center">
                  <i class="fas fa-calendar mr-2"></i>
                  Dibuat pada: {{ now()->format('d M Y') }}
                </div>
              </div>
            </div>
          </div>

          {{-- Submit Buttons --}}
          <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.kuesioners.index') }}"
              class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition shadow-md">
              Batal
            </a>
            <button type="submit"
              class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition shadow-md">
              <i class="fas fa-save mr-2"></i>
              Simpan Kuesioner
            </button>
          </div>
          
          {{-- Info Note --}}
          <div class="mt-6 p-4 bg-yellow-50 border-l-4 border-yellow-400">
            <div class="flex">
              <div class="flex-shrink-0">
                <i class="fas fa-lightbulb text-yellow-400"></i>
              </div>
              <div class="ml-3">
                <p class="text-sm text-yellow-700">
                  <strong>Tips:</strong> Setelah kuesioner dibuat, Anda dapat menambahkan pertanyaan, 
                  mengatur halaman, dan menyesuaikan tampilan melalui menu pengelolaan pertanyaan.
                </p>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  {{-- JavaScript for live preview --}}
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const namaInput = document.getElementById('nama');
      const previewTitle = document.getElementById('preview-title');
      
      if (namaInput && previewTitle) {
        namaInput.addEventListener('input', function() {
          const value = this.value.trim();
          previewTitle.textContent = value || 'Nama Kuesioner Anda';
        });
      }
    });
  </script>

  {{-- Custom CSS for animations --}}
  <style>
    .animate-fade-in {
      animation: fadeInUp 0.6s ease-out;
    }
    
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</x-app-layout>