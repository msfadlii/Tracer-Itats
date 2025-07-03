<x-app-layout>
  <x-slot name="header">
    <div class="mb-6 flex items-start gap-4 animate-fade-in">
      <div class="border-l-4 border-blue-600 pl-4">
        <h2 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
          <i class="fas fa-clipboard-list text-blue-600"></i>
          Kelola Kuesioner
        </h2>
        <p class="text-sm text-gray-600 mt-1">
          Daftar semua kuesioner dan preview tampilan kuesioner.
        </p>
      </div>
    </div>
  </x-slot>

  <div class="py-8 bg-gray-50 min-h-screen text-gray-800">
    <div class="max-w-7xl mx-auto px-4">
      
      {{-- Action Buttons --}}
      <div class="mb-6">
        <a href="{{ route('admin.kuesioners.create') }}" 
          class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition shadow-md">
          <i class="fas fa-plus mr-2"></i>
          Tambah Kuesioner Baru
        </a>
      </div>

      {{-- Success Message --}}
      @if (session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-700 border border-green-300 rounded-md shadow-sm">
          <i class="fas fa-check-circle mr-2"></i>
          {{ session('success') }}
        </div>
      @endif

      {{-- Kuesioner Table --}}
      <div class="bg-white shadow rounded-xl overflow-hidden mb-8">
        <div class="px-6 py-4 bg-gray-50 border-b">
          <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
            <i class="fas fa-table text-gray-600"></i>
            Daftar Kuesioner
          </h3>
        </div>
        
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  No
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Nama Kuesioner
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Tanggal Dibuat
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Aksi
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @forelse($kuesioners as $index => $kuesioner)
                <tr class="hover:bg-gray-50 transition-colors">
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    {{ $index + 1 }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">
                      {{ $kuesioner->nama }}
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $kuesioner->created_at->format('d M Y, H:i') }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                    <a href="{{ route('admin.kuesioners.edit', $kuesioner->id) }}" 
                      class="inline-flex items-center px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white rounded transition shadow-sm">
                      <i class="fas fa-edit mr-1"></i>
                      Edit
                    </a>
                    <form action="{{ route('admin.kuesioners.destroy', $kuesioner->id) }}" method="POST" class="inline-block"
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus kuesioner ini?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" 
                        class="inline-flex items-center px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded transition shadow-sm">
                        <i class="fas fa-trash mr-1"></i>
                        Hapus
                      </button>
                    </form>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                    <div class="flex flex-col items-center">
                      <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                      <p class="text-lg">Belum ada kuesioner yang dibuat</p>
                      <p class="text-sm">Klik tombol "Tambah Kuesioner Baru" untuk memulai</p>
                    </div>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

      {{-- Google Forms Style Preview --}}
      @if($kuesioners->count() > 0)
        <div class="bg-white shadow rounded-xl overflow-hidden">
          <div class="px-6 py-4 bg-purple-50 border-b">
            <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
              <i class="fas fa-eye text-purple-600"></i>
              Preview Kuesioner (CONTOH!!)
            </h3>
            <p class="text-sm text-gray-600 mt-1">
              Tampilan preview contoh kuesioner 
            </p>
          </div>

          <div class="p-6">
            {{-- Kuesioner Selector --}}
            <div class="mb-6">
              <label for="kuesioner-selector" class="block text-sm font-medium text-gray-700 mb-2">
                Pilih Kuesioner untuk Preview:
              </label>
              <select id="kuesioner-selector" 
                class="w-full md:w-1/3 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                @foreach($kuesioners as $kuesioner)
                  <option value="{{ $kuesioner->id }}" {{ $loop->first ? 'selected' : '' }}>
                    {{ $kuesioner->nama }}
                  </option>
                @endforeach
              </select>
            </div>

            {{-- Google Forms Style Preview --}}
            <div class="max-w-4xl mx-auto">
              @foreach($kuesioners as $kuesioner)
                <div id="preview-{{ $kuesioner->id }}" class="kuesioner-preview {{ !$loop->first ? 'hidden' : '' }}">
                  {{-- Header --}}
                  <div class="bg-gradient-to-r from-purple-800 to-blue-900 rounded-t-lg p-6 text-white">
                    <div class="border-l-4 border-white pl-4">
                      <h1 class="text-2xl font-bold mb-2">{{ $kuesioner->nama }}</h1>
                      <p class="text-purple-100">
                        <i class="fas fa-info-circle mr-2"></i>
                        Silakan lengkapi kuesioner berikut dengan jujur dan sesuai dengan kondisi Anda.
                      </p>
                    </div>
                  </div>

                  {{-- Form Content --}}
                  <div class="bg-white border-x border-b rounded-b-lg p-6 space-y-6">
                    
                    {{-- Sample Questions (Google Forms Style) --}}
                    <div class="space-y-8">
                      
                      {{-- Question 1: Multiple Choice --}}
                      <div class="bg-gray-50 p-6 rounded-lg border-l-4 border-purple-500">
                        <div class="flex items-start justify-between mb-4">
                          <h3 class="text-lg font-medium text-gray-800">
                            1. Apa jenis kelamin Anda? 
                            <span class="text-red-500">*</span>
                          </h3>
                          <span class="text-xs bg-purple-100 text-purple-700 px-2 py-1 rounded-full">
                            Pilihan Ganda
                          </span>
                        </div>
                        <div class="space-y-3">
                          <label class="flex items-center space-x-3 cursor-pointer hover:bg-white p-2 rounded transition">
                            <input type="radio" name="gender" value="laki-laki" class="text-purple-600 focus:ring-purple-500">
                            <span class="text-gray-700">Laki-laki</span>
                          </label>
                          <label class="flex items-center space-x-3 cursor-pointer hover:bg-white p-2 rounded transition">
                            <input type="radio" name="gender" value="perempuan" class="text-purple-600 focus:ring-purple-500">
                            <span class="text-gray-700">Perempuan</span>
                          </label>
                        </div>
                      </div>

                      {{-- Question 2: Text Input --}}
                      <div class="bg-gray-50 p-6 rounded-lg border-l-4 border-blue-500">
                        <div class="flex items-start justify-between mb-4">
                          <h3 class="text-lg font-medium text-gray-800">
                            2. Nama lengkap Anda
                            <span class="text-red-500">*</span>
                          </h3>
                          <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full">
                            Teks Pendek
                          </span>
                        </div>
                        <input type="text" placeholder="Masukkan nama lengkap Anda" 
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                      </div>

                      {{-- Question 3: Multiple Selection --}}
                      <div class="bg-gray-50 p-6 rounded-lg border-l-4 border-green-500">
                        <div class="flex items-start justify-between mb-4">
                          <h3 class="text-lg font-medium text-gray-800">
                            3. Hobi yang Anda miliki (boleh pilih lebih dari satu)
                          </h3>
                          <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">
                            Kotak Centang
                          </span>
                        </div>
                        <div class="space-y-3">
                          <label class="flex items-center space-x-3 cursor-pointer hover:bg-white p-2 rounded transition">
                            <input type="checkbox" class="text-green-600 focus:ring-green-500 rounded">
                            <span class="text-gray-700">Membaca</span>
                          </label>
                          <label class="flex items-center space-x-3 cursor-pointer hover:bg-white p-2 rounded transition">
                            <input type="checkbox" class="text-green-600 focus:ring-green-500 rounded">
                            <span class="text-gray-700">Olahraga</span>
                          </label>
                          <label class="flex items-center space-x-3 cursor-pointer hover:bg-white p-2 rounded transition">
                            <input type="checkbox" class="text-green-600 focus:ring-green-500 rounded">
                            <span class="text-gray-700">Musik</span>
                          </label>
                          <label class="flex items-center space-x-3 cursor-pointer hover:bg-white p-2 rounded transition">
                            <input type="checkbox" class="text-green-600 focus:ring-green-500 rounded">
                            <span class="text-gray-700">Traveling</span>
                          </label>
                        </div>
                      </div>

                      {{-- Question 4: Long Text --}}
                      <div class="bg-gray-50 p-6 rounded-lg border-l-4 border-yellow-500">
                        <div class="flex items-start justify-between mb-4">
                          <h3 class="text-lg font-medium text-gray-800">
                            4. Ceritakan pengalaman menarik Anda
                          </h3>
                          <span class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full">
                            Paragraf
                          </span>
                        </div>
                        <textarea rows="4" placeholder="Ceritakan pengalaman menarik Anda..." 
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent resize-none"></textarea>
                      </div>

                      {{-- Question 5: Scale/Rating --}}
                      <div class="bg-gray-50 p-6 rounded-lg border-l-4 border-red-500">
                        <div class="flex items-start justify-between mb-4">
                          <h3 class="text-lg font-medium text-gray-800">
                            5. Seberapa puas Anda dengan layanan kami?
                          </h3>
                          <span class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded-full">
                            Skala Linear
                          </span>
                        </div>
                        <div class="flex items-center justify-between">
                          <span class="text-sm text-gray-600">Sangat Tidak Puas</span>
                          <div class="flex space-x-4">
                            @for($i = 1; $i <= 5; $i++)
                              <label class="flex flex-col items-center cursor-pointer">
                                <input type="radio" name="satisfaction" value="{{ $i }}" class="text-red-600 focus:ring-red-500 mb-1">
                                <span class="text-xs text-gray-600">{{ $i }}</span>
                              </label>
                            @endfor
                          </div>
                          <span class="text-sm text-gray-600">Sangat Puas</span>
                        </div>
                      </div>
                    </div>

                    {{-- Form Footer --}}
                    <div class="pt-6 border-t border-gray-200">
                      <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-500">
                          <i class="fas fa-lock mr-1"></i>
                          Form ini tidak pernah digunakan untuk spam atau mengirim email yang tidak diinginkan.
                        </div>
                        <div class="space-x-3">
                          <button type="button" class="px-6 py-2 text-gray-700 bg-gray-200 hover:bg-gray-300 rounded-lg transition">
                            Bersihkan form
                          </button>
                          <button type="submit" class="px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition shadow-md">
                            Kirim
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        </div>
      @endif
    </div>
  </div>

  {{-- JavaScript for Preview Switching --}}
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const selector = document.getElementById('kuesioner-selector');
      const previews = document.querySelectorAll('.kuesioner-preview');
      
      if (selector) {
        selector.addEventListener('change', function() {
          // Hide all previews
          previews.forEach(preview => preview.classList.add('hidden'));
          
          // Show selected preview
          const selectedPreview = document.getElementById('preview-' + this.value);
          if (selectedPreview) {
            selectedPreview.classList.remove('hidden');
          }
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