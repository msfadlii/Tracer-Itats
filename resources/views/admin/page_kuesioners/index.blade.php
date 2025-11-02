{{-- resources/views/admin/page_kuesioners/index.blade.php --}}
<x-app-layout>
  <x-slot name="header">
    <div class="mb-6 flex items-start gap-4 animate-fade-in">
      <div class="border-l-4 border-blue-600 pl-4">
        <h2 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
          <i class="fas fa-file-alt text-blue-600"></i>
          Halaman Kuesioner
        </h2>
        <p class="text-sm text-gray-600 mt-1">
          Kelola semua halaman kuesioner sistem.
        </p>
      </div>
    </div>
  </x-slot>

  <div class="py-8 bg-gray-50 min-h-screen text-gray-800">
    <div class="max-w-6xl mx-auto px-4">

      {{-- Info Panel --}}
      <div class="mb-6 p-4 bg-indigo-50 rounded-lg border border-indigo-200">
        <h3 class="text-sm font-semibold text-indigo-800 mb-2">
          <i class="fas fa-info-circle mr-2"></i>
          Informasi Halaman Kuesioner
        </h3>
        <p class="text-sm text-indigo-700 mb-2">
          Setiap halaman dapat berisi pertanyaan yang ditampilkan berdasarkan status kerja alumni yang dipilih saat
          mengisi kuesioner.
        </p>
        <div class="bg-indigo-100 p-3 rounded-md">
          <p class="text-xs text-indigo-600">
            <i class="fas fa-filter mr-1"></i>
            <strong>Kondisi Tampil:</strong> Pertanyaan dalam halaman akan muncul secara dinamis sesuai dengan kondisi
            status kerja yang dikonfigurasi di menu "Pertanyaan".
          </p>
        </div>
      </div>

      {{-- Add Button --}}
      <div class="flex justify-between items-center mb-6">
        <div></div>
        <a href="{{ route('admin.page_kuesioners.create') }}"
          class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition shadow-md">
          <i class="fas fa-plus mr-2"></i>
          Tambah Halaman
        </a>
      </div>

      {{-- Success Message --}}
      @if (session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-700 border border-green-300 rounded-md shadow-sm">
          <i class="fas fa-check-circle mr-2"></i>
          {{ session('success') }}
        </div>
      @endif

      {{-- Pages List --}}
      <div class="bg-white shadow rounded-xl overflow-hidden">
        @if($halamans->count() > 0)
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    #
                  </th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Judul Halaman
                  </th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Deskripsi
                  </th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Urutan
                  </th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Dibuat
                  </th>
                  <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Aksi
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                @foreach($halamans as $index => $halaman)
                  <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                      {{ $index + 1 }}
                    </td>
                    <td class="px-6 py-4">
                      <div class="text-sm font-medium text-gray-900">
                        {{ $halaman->judul }}
                      </div>
                    </td>
                    <td class="px-6 py-4">
                      <div class="text-sm text-gray-500 max-w-xs truncate">
                        {{ $halaman->deskripsi ?? '-' }}
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        {{ $halaman->urutan }}
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                      {{ $halaman->created_at->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                      <div class="flex items-center justify-end space-x-2">
                        <a href="{{ route('admin.page_kuesioners.edit', $halaman->id) }}"
                          class="inline-flex items-center px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white text-xs rounded transition">
                          <i class="fas fa-edit mr-1"></i>
                          Edit
                        </a>

                        <form action="{{ route('admin.page_kuesioners.destroy', $halaman->id) }}" method="POST"
                          class="inline-block" onsubmit="return confirm('Yakin ingin menghapus halaman ini?')">
                          @csrf
                          @method('DELETE')
                          <button type="submit"
                            class="inline-flex items-center px-3 py-1 bg-red-500 hover:bg-red-600 text-white text-xs rounded transition">
                            <i class="fas fa-trash mr-1"></i>
                            Hapus
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @else
          <div class="text-center py-12">
            <div class="text-gray-400 mb-4">
              <i class="fas fa-file-alt text-6xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Halaman</h3>
            <p class="text-gray-500 mb-6">Mulai dengan menambahkan halaman pertama untuk kuesioner.</p>
            <a href="{{ route('admin.page_kuesioners.create') }}"
              class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition shadow-md">
              <i class="fas fa-plus mr-2"></i>
              Tambah Halaman Pertama
            </a>
          </div>
        @endif
      </div>
    </div>
  </div>
</x-app-layout>