<x-app-layout>
  <x-slot name="header">
    <div class="mb-6 flex items-start gap-4 animate-fade-in">
      <div class="border-l-4 border-blue-600 pl-4">
        <h2 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
          <i class="fas fa-list-alt text-blue-600"></i>
          Daftar Pertanyaan
        </h2>
        <p class="text-sm text-gray-600 mt-1">
          Lihat dan kelola semua pertanyaan yang tersedia di sistem.
        </p>
      </div>
    </div>
  </x-slot>

  <div class="py-8 bg-gray-50 min-h-screen text-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="bg-white shadow-xl rounded-xl overflow-hidden">

        {{-- Header Section --}}
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
          <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

            {{-- Search and Filter Form --}}
            <form method="GET" action="{{ route('admin.questions.index') }}" class="flex-1">
              <div class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1">
                  <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari pertanyaan..."
                      class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                  </div>
                </div>

                <div class="flex-1 max-w-xs">
                  <select name="Status_saat_ini"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                    <option value="">Semua Status Kerja</option>
                    @foreach($statusList as $status)
            <option value="{{ $status }}" {{ request('Status_saat_ini') == $status ? 'selected' : '' }}>
              {{ $status }}
            </option>
          @endforeach
                  </select>
                </div>

                <div class="flex gap-2">
                  <button type="submit"
                    class="px-6 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-md hover:shadow-lg">
                    <i class="fas fa-filter mr-2"></i>Filter
                  </button>

                  @if(request()->hasAny(['search', 'Status_saat_ini']))
            <a href="{{ route('admin.questions.index') }}"
            class="px-6 py-2.5 bg-gray-500 text-white font-medium rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200 shadow-md hover:shadow-lg">
            <i class="fas fa-times mr-2"></i>Reset
            </a>
          @endif
                </div>
              </div>
            </form>

            {{-- Add Question Button --}}
            <div class="flex-shrink-0">
              <a href="{{ route('admin.questions.create') }}"
                class="inline-flex items-center px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200">
                <i class="fas fa-plus mr-2"></i>
                Tambah Pertanyaan
              </a>
            </div>
          </div>
        </div>

        {{-- Content Section --}}
        <div class="p-6">
          {{-- Success Message --}}
          @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg shadow-sm">
        <div class="flex items-center">
          <i class="fas fa-check-circle mr-3 text-green-600"></i>
          <span class="font-medium">{{ session('success') }}</span>
        </div>
        </div>
      @endif

          {{-- Results Info --}}
          @if($questions->total() > 0)
        <div class="mb-4 flex items-center justify-between">
        <div class="text-sm text-gray-600">
          Menampilkan {{ $questions->firstItem() }} - {{ $questions->lastItem() }} dari {{ $questions->total() }}
          pertanyaan
          @if(request('search'))
        untuk pencarian "<strong>{{ request('search') }}</strong>"
      @endif
          @if(request('Status_saat_ini'))
        dengan status "<strong>{{ request('Status_saat_ini') }}</strong>"
      @endif
        </div>
        </div>
      @endif

          {{-- Table --}}
          <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col"
                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    No
                  </th>
                  <th scope="col"
                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Pertanyaan
                  </th>
                  <th scope="col"
                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Tipe
                  </th>
                  <th scope="col"
                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Status
                  </th>
                  <th scope="col"
                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Judul Halaman Kuesioner
                  </th>
                  <th scope="col"
                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Kondisi Tampil
                  </th>
                  <th scope="col"
                    class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Aksi
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($questions as $index => $question)
            <tr class="hover:bg-gray-50 transition-colors duration-200">
              {{-- Number --}}
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
              {{ ($questions->currentPage() - 1) * $questions->perPage() + $index + 1 }}
              </td>

              {{-- Question Text --}}
              <td class="px-6 py-4">
              <div class="max-w-sm">
                <p class="text-sm font-medium text-gray-900 mb-1" title="{{ $question->teks }}">
                {{ Str::limit($question->teks, 60) }}
                </p>
                <div class="flex items-center gap-4 text-xs text-gray-500">
                @if($question->visualisasi)
            <span
            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-700">
            <i class="fas fa-chart-bar mr-1"></i>Visualisasi Pertanyaan
            </span>
          @endif
                @if($question->opsiJawabans->count() > 0)
            <span class="text-gray-500">
            <i class="fas fa-list mr-1"></i>{{ $question->opsiJawabans->count() }} opsi
            </span>
          @endif
                </div>
              </div>
              </td>

              {{-- Question Type --}}
              <td class="px-6 py-4 whitespace-nowrap">
              <span
                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                {{ $question->jenisPertanyaan ? ucfirst($question->jenisPertanyaan->nama) : 'Tidak diketahui' }}
              </span>
              </td>

              {{-- Status Column --}}
              <td class="px-6 py-4 whitespace-nowrap">
              <div class="flex flex-col gap-1">
                <span
                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $question->wajib ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                {{ $question->wajib ? 'Wajib Diisi' : 'Opsional' }}
                </span>
                <span class="text-xs text-gray-500">
                Urutan: {{ $question->urutan }}
                </span>
              </div>
              </td>

              {{-- Page --}}
              <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm text-gray-900">
                {{ $question->halamanKuesioner ? $question->halamanKuesioner->judul : '-' }}
              </div>
              </td>

              {{-- Employment Conditions --}}
              <td class="px-6 py-4">
              <div class="max-w-xs">
                @if($question->kondisiPertanyaan->count() > 0)
              <div class="flex flex-wrap gap-1">
              @foreach ($question->kondisiPertanyaan as $condition)
            @if($condition->field === 'status')
            <span class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-medium">
            {{ Str::limit($condition->nilai_status_kerja, 25) }}
            </span>
            @endif
          @endforeach
              </div>
          @else
            <span
            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
            <i class="fas fa-globe mr-1"></i>Semua status
            </span>
          @endif
              </div>
              </td>

              {{-- Actions --}}
              <td class="px-6 py-4 whitespace-nowrap text-center">
              <div class="flex items-center justify-center space-x-3">
                {{-- View Button --}}
                <button type="button" onclick="showQuestionDetail({{ $question->id }})"
                class="text-green-600 hover:text-green-800 hover:bg-green-50 p-2 rounded-full transition-all duration-200"
                title="Lihat Detail">
                <i class="fas fa-eye"></i>
                </button>

                {{-- Edit Button --}}
                <a href="{{ route('admin.questions.edit', $question->id) }}"
                class="text-blue-600 hover:text-blue-800 hover:bg-blue-50 p-2 rounded-full transition-all duration-200"
                title="Edit Pertanyaan">
                <i class="fas fa-edit"></i>
                </a>

                {{-- Delete Button --}}
                <form action="{{ route('admin.questions.destroy', $question->id) }}" method="POST"
                class="inline-block" onsubmit="return confirmDelete()">
                @csrf
                @method('DELETE')
                <button type="submit"
                  class="text-red-600 hover:text-red-800 hover:bg-red-50 p-2 rounded-full transition-all duration-200"
                  title="Hapus Pertanyaan">
                  <i class="fas fa-trash-alt"></i>
                </button>
                </form>
              </div>
              </td>
            </tr>
        @empty
            <tr>
              <td colspan="7" class="px-6 py-12 text-center">
              <div class="flex flex-col items-center justify-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-question-circle text-2xl text-gray-400"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada pertanyaan</h3>
                <p class="text-sm text-gray-500 mb-4">
                @if(request()->hasAny(['search', 'Status_saat_ini']))
            Tidak ada pertanyaan yang sesuai dengan filter yang dipilih.
          @else
            Silakan tambah pertanyaan baru untuk memulai.
          @endif
                </p>
                @if(!request()->hasAny(['search', 'Status_saat_ini']))
            <a href="{{ route('admin.questions.create') }}"
            class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
            <i class="fas fa-plus mr-2"></i>
            Tambah Pertanyaan Pertama
            </a>
          @endif
              </div>
              </td>
            </tr>
        @endforelse
              </tbody>
            </table>
          </div>

          {{-- Pagination --}}
          @if($questions->hasPages())
        <div class="mt-6 flex items-center justify-between">
        <div class="text-sm text-gray-600">
          Halaman {{ $questions->currentPage() }} dari {{ $questions->lastPage() }}
        </div>
        <div class="flex items-center space-x-2">
          {{ $questions->withQueryString()->links() }}
        </div>
        </div>
      @endif
        </div>
      </div>
    </div>
  </div>

  {{-- Question Detail Modal --}}
  <div id="questionDetailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
      <div class="bg-white rounded-xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
        {{-- Modal Header --}}
        <div class="flex justify-between items-center p-6 border-b border-gray-200 bg-gray-50">
          <h3 class="text-xl font-semibold text-gray-800 flex items-center">
            <i class="fas fa-info-circle mr-3 text-blue-600"></i>
            Detail Pertanyaan
          </h3>
          <button onclick="closeQuestionDetail()"
            class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 p-2 rounded-full transition-all duration-200">
            <i class="fas fa-times text-xl"></i>
          </button>
        </div>

        {{-- Modal Content --}}
        <div id="questionDetailContent" class="p-6 overflow-y-auto max-h-[calc(90vh-120px)]">
          <div class="flex items-center justify-center py-8">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
            <span class="ml-3 text-gray-600">Memuat detail...</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- JavaScript --}}
  <script>
    function showQuestionDetail(questionId) {
      const questions = @json($questions->items());
      const question = questions.find(q => q.id === questionId);

      if (!question) {
        alert('Data pertanyaan tidak ditemukan');
        return;
      }

      let content = `
        <div class="space-y-6">
          {{-- Question Text --}}
          <div class="bg-blue-50 p-4 rounded-lg">
            <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
              <i class="fas fa-question-circle mr-2 text-blue-600"></i>
              Teks Pertanyaan
            </h4>
            <p class="text-gray-700 leading-relaxed">${question.teks}</p>
          </div>
          
          {{-- Basic Info --}}
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="bg-white border border-gray-200 p-4 rounded-lg">
              <h5 class="font-medium text-gray-600 mb-2">Jenis Pertanyaan</h5>
              <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                ${question.jenis_pertanyaan ? question.jenis_pertanyaan.nama : 'Tidak diketahui'}
              </span>
            </div>
            
            <div class="bg-white border border-gray-200 p-4 rounded-lg">
              <h5 class="font-medium text-gray-600 mb-2">Status Wajib</h5>
              <span class="inline-block px-3 py-1 ${question.wajib ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600'} rounded-full text-sm font-medium">
                ${question.wajib ? 'Wajib Diisi' : 'Opsional'}
              </span>
            </div>
            
            <div class="bg-white border border-gray-200 p-4 rounded-lg">
              <h5 class="font-medium text-gray-600 mb-2">Urutan</h5>
              <span class="text-lg font-semibold text-gray-800">${question.urutan}</span>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-white border border-gray-200 p-4 rounded-lg">
              <h5 class="font-medium text-gray-600 mb-2">Halaman Kuesioner</h5>
              <p class="text-gray-800">${question.halaman_kuesioner ? question.halaman_kuesioner.judul : 'Judul Halaman KuesionerBelum ditentukan'}</p>
            </div>
            
            <div class="bg-white border border-gray-200 p-4 rounded-lg">
              <h5 class="font-medium text-gray-600 mb-2">Visualisasi</h5>
              <span class="inline-block px-3 py-1 ${question.visualisasi ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-600'} rounded-full text-sm font-medium">
                ${question.visualisasi ? 'Aktif' : 'Tidak Aktif'}
              </span>
            </div>
          </div>
      `;

      // Add answer options
      if (question.opsi_jawabans && question.opsi_jawabans.length > 0) {
        content += `
          <div class="bg-white border border-gray-200 p-4 rounded-lg">
            <h5 class="font-medium text-gray-600 mb-3 flex items-center">
              <i class="fas fa-list mr-2 text-green-600"></i>
              Opsi Jawaban (${question.opsi_jawabans.length})
            </h5>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
              ${question.opsi_jawabans.map((opsi, index) => `
                <div class="flex items-center p-2 bg-gray-50 rounded border text-sm">
                  <span class="w-6 h-6 bg-blue-100 text-blue-800 rounded-full flex items-center justify-center text-xs font-medium mr-3">
                    ${index + 1}
                  </span>
                  <span class="flex-1">${opsi.teks}</span>
                </div>
              `).join('')}
            </div>
            ${question.punya_opsi_lain ? `
              <div class="mt-2 p-2 bg-yellow-50 border border-yellow-200 rounded text-sm">
                <i class="fas fa-plus mr-2 text-yellow-600"></i>
                <span class="text-yellow-800">Memiliki opsi "Lainnya"</span>
              </div>
            ` : ''}
          </div>
        `;
      }

      // Add employment conditions
      if (question.kondisi_pertanyaans && question.kondisi_pertanyaans.length > 0) {
        content += `
          <div class="bg-white border border-gray-200 p-4 rounded-lg">
            <h5 class="font-medium text-gray-600 mb-3 flex items-center">
              <i class="fas fa-filter mr-2 text-orange-600"></i>
              Kondisi Tampil (${question.kondisi_pertanyaans.length})
            </h5>
            <div class="flex flex-wrap gap-2">
              ${question.kondisi_pertanyaans.map(kondisi => `
                <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                  ${kondisi.nilai_status_kerja}
                </span>
              `).join('')}
            </div>
          </div>
        `;
      }

      // Add extra attributes
      if (question.atribut_ekstra) {
        try {
          const attrs = JSON.parse(question.atribut_ekstra);
          content += `
            <div class="bg-white border border-gray-200 p-4 rounded-lg">
              <h5 class="font-medium text-gray-600 mb-3 flex items-center">
                <i class="fas fa-cog mr-2 text-gray-600"></i>
                Atribut Ekstra
              </h5>
              <div class="bg-gray-50 p-3 rounded border overflow-x-auto">
                <pre class="text-sm text-gray-700 whitespace-pre-wrap">${JSON.stringify(attrs, null, 2)}</pre>
              </div>
            </div>
          `;
        } catch (e) {
          content += `
            <div class="bg-white border border-gray-200 p-4 rounded-lg">
              <h5 class="font-medium text-gray-600 mb-3 flex items-center">
                <i class="fas fa-cog mr-2 text-gray-600"></i>
                Atribut Ekstra
              </h5>
              <div class="bg-gray-50 p-3 rounded border">
                <span class="text-sm text-gray-700">${question.atribut_ekstra}</span>
              </div>
            </div>
          `;
        }
      }

      if (question.jenis_pertanyaan && question.jenis_pertanyaan.nama === 'matrix') {
  const baris = question.baris_matrixs ?? [];
  let kolom = [];

  try {
    const attrs = JSON.parse(question.atribut_ekstra);
    kolom = attrs.columns ?? [];
  } catch (e) {}

  content += `
    <div class="bg-white border border-gray-200 p-4 rounded-lg">
      <h5 class="font-medium text-gray-600 mb-3 flex items-center">
        <i class="fas fa-table mr-2 text-purple-600"></i>
        Detail Pertanyaan Matrix
      </h5>

      <div class="mb-3">
        <strong class="text-sm text-gray-500 block mb-1">Baris (${baris.length}):</strong>
        <div class="grid grid-cols-1 gap-2">
          ${baris.map((baris, index) => `
            <div class="flex items-center p-2 bg-gray-50 rounded border text-sm">
              <span class="w-6 h-6 bg-purple-100 text-purple-800 rounded-full flex items-center justify-center text-xs font-medium mr-3">
                ${index + 1}
              </span>
              <span class="flex-1">${baris.label}</span>
            </div>
          `).join('')}
        </div>
      </div>

      <div>
        <strong class="text-sm text-gray-500 block mb-1">Kolom (${kolom.length}):</strong>
        <div class="flex flex-wrap gap-2">
          ${kolom.map((col, index) => `
            <span class="bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-sm font-medium">
              ${index + 1}. ${col}
            </span>
          `).join('')}
        </div>
      </div>
    </div>
  `;
}



      content += '</div>';

      document.getElementById('questionDetailContent').innerHTML = content;
      document.getElementById('questionDetailModal').classList.remove('hidden');
      document.body.style.overflow = 'hidden';
    }

    function closeQuestionDetail() {
      document.getElementById('questionDetailModal').classList.add('hidden');
      document.body.style.overflow = 'auto';
    }

    function confirmDelete() {
      return confirm('Apakah Anda yakin ingin menghapus pertanyaan ini?\n\nTindakan ini tidak dapat dibatalkan dan akan menghapus semua data terkait.');
    }

    // Close modal when clicking outside
    document.getElementById('questionDetailModal').addEventListener('click', function (e) {
      if (e.target === this) {
        closeQuestionDetail();
      }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && !document.getElementById('questionDetailModal').classList.contains('hidden')) {
        closeQuestionDetail();
      }
    });
  </script>
</x-app-layout>