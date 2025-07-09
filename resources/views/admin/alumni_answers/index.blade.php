<x-app-layout>
    <x-slot name="header">
        <div class="mb-8 py-6 px-8 relative overflow-hidden">
            <!-- Background Gradient -->
            <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 opacity-80"></div>
           
            <!-- Content -->
            <div class="relative flex items-center gap-6 p-6 animate-fade-in">
                <!-- Icon Container -->
                <div class="flex-shrink-0">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 via-blue-600 to-indigo-600 rounded-2xl shadow-lg flex items-center justify-center transform hover:scale-105 transition-transform duration-300">
                        <i class="fas fa-users text-white text-2xl"></i>
                    </div>
                </div>
                
                <!-- Text Content -->
                <div class="flex-1">
                    <h2 class="text-4xl font-bold bg-gradient-to-r from-gray-900 via-blue-800 to-indigo-800 bg-clip-text text-transparent mb-2">
                        Jawaban Alumni
                    </h2>
                    <p class="text-gray-600 text-lg leading-relaxed max-w-2xl">
                        Tinjau data hasil pengisian survei alumni yang mencakup identitas, status, dan tanggapan mereka terhadap pertanyaan yang diberikan.
                    </p>
                    
                    <!-- Stats Pills -->
                    <div class="flex gap-3 mt-6">
                        <div class="bg-white/80 text-center backdrop-blur-md rounded-full px-6 py-2 border border-blue-300 shadow-md">
                            <span class="text-base font-semibold text-blue-800 tracking-wide">
                                Total Responden: {{ count($dataAlumni) }}
                            </span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </x-slot>

    <div class="flex min-h-screen">
        <!-- Sidebar Filter -->
        <div id="overlay" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40 hidden transition-all duration-300"></div>
    
        <!-- Enhanced Filter Sidebar -->
        <div id="filterSidebar" class="fixed inset-y-0 right-0 w-96 bg-white/95 backdrop-blur-xl shadow-2xl border-l border-gray-200 transform translate-x-full transition-all duration-500 z-50 overflow-y-auto">
            <div class="p-8">
                <!-- Enhanced Header -->
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 via-blue-500 to-indigo-500 rounded-2xl flex items-center justify-center shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent">Filter</h3>
                        </div>
                    </div>
                    
                    <button 
                        type="button"
                        onclick="toggleFilter()" 
                        class="w-10 h-10 rounded-xl bg-gray-100 hover:bg-red-50 text-gray-400 hover:text-red-500 transition-all duration-200 flex items-center justify-center group"
                        aria-label="Tutup Filter">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:rotate-90 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Enhanced Filter Form -->
                <form method="GET" action="#" class="space-y-6">
                    
                    <!-- Enhanced Search Input -->
                    <div class="relative group">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-purple-400 rounded-xl blur opacity-20 group-hover:opacity-30 transition-opacity duration-300"></div>
                        <div class="relative bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-all duration-300">
                            <input
                                type="text"
                                id="filterKeyword"
                                name="keyword"
                                placeholder="🔍 Cari pertanyaan atau keyword..."
                                class="w-full px-4 py-4 border-0 rounded-xl bg-transparent text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200"
                                value=""
                            >
                        </div>
                    </div>

                    <!-- Enhanced Date Input -->
                    <div class="relative group">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">📅 Tanggal Mulai</label>
                        <div class="relative bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-all duration-300">
                            <input
                                type="date"
                                name="start_date"
                                class="w-full px-4 py-4 border-0 rounded-xl bg-transparent text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200"
                            >
                        </div>
                    </div>

                    <!-- Enhanced Graduation Year Select -->
                    <div class="relative group">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">🎓 Tahun Lulus</label>
                        <div class="relative bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-all duration-300">
                            <select name="tahun_lulus" class="w-full px-4 py-4 border-0 rounded-xl bg-transparent text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 appearance-none cursor-pointer">
                                <option value="all">Semua Tahun</option>
                                @foreach ($tahunLulusTersedia as $tahun)
                                    <option value="{{ $tahun }}" @if(request('tahun_lulus') == $tahun) selected @endif>
                                        {{ $tahun }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Employment Status Select -->
                    <div class="relative group">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">💼 Status Kerja</label>
                        <div class="relative bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-all duration-300">
                            <select name="status_kerja" class="w-full px-4 py-4 border-0 rounded-xl bg-transparent text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 appearance-none cursor-pointer">
                                <option value="all">Semua Status</option>
                                @foreach ($statusKerjaTersedia as $status)
                                    <option value="{{ $status }}" @if(request('status_kerja') == $status) selected @endif>
                                        {{ ucfirst(str_replace('_', ' ', $status)) }}
                                    </option>
                                @endforeach
                            </select>               
                            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Action Buttons -->
                    <div class="flex flex-col space-y-3 pt-6">
                        <button
                            type="submit"
                            class="relative overflow-hidden bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5 group"
                        >
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-700 to-indigo-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <span class="relative flex items-center justify-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <span>Terapkan Filter</span>
                            </span>
                        </button>

                        <button
                            type="button"
                            onclick="resetFilter()"
                            class="relative overflow-hidden bg-gradient-to-r from-gray-500 to-gray-600 text-white font-semibold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5 group"
                        >
                            <div class="absolute inset-0 bg-gradient-to-r from-gray-600 to-gray-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <span class="relative flex items-center justify-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                <span>Reset Filter</span>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="py-10 p-8 overflow-auto flex-1 min-h-screen bg-gradient-to-br from-gray-50 to-blue-50">
            <!-- Enhanced Modal -->
            <div id="detailModal" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm items-center justify-center opacity-0 pointer-events-none transition-all duration-300 ease-in-out hidden">
                <div class="bg-white rounded-3xl shadow-2xl w-full max-w-5xl p-8 relative overflow-hidden max-h-[90vh] border border-gray-200 mx-4">
                    <!-- Modal Header -->
                    <div class="flex justify-between items-start mb-6 pb-6 border-b border-gray-200">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-2xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900">Detail Jawaban Alumni</h3>
                                <p class="text-sm text-gray-500">Data lengkap yang diisi oleh alumni</p>
                            </div>
                        </div>
                        <button onclick="closeModal()" class="w-10 h-10 bg-gray-100 hover:bg-red-50 text-gray-400 hover:text-red-500 rounded-xl transition-all duration-200 flex items-center justify-center group">
                            <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Content -->
                    <div id="modalContent" class="space-y-3 text-sm text-gray-800 max-h-[60vh] overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                        <!-- Content will be loaded here -->
                    </div>
                </div>
            </div>

            <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Search Bar -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <div class="flex flex-col sm:flex-row gap-4 items-center justify-between">
                        <!-- Enhanced Search Bar -->
                        <div class="relative flex-1 max-w-md">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input
                                type="text"
                                id="tableSearchInput"
                                class="w-full pl-10 pr-4 py-3 bg-gray-200 border border-gray-200 rounded-xl text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                placeholder="Cari jawaban alumni..."
                                onkeyup="searchTable()"
                            >
                        </div>

                        <!-- Enhanced Filter Button -->
                        <button onclick="toggleFilter()" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-6 py-3 rounded-xl flex items-center space-x-2 font-medium shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L15 14.414V19a1 1 0 01-1.447.894l-4-2A1 1 0 019 17v-2.586L3.293 6.707A1 1 0 013 6V4z" />
                            </svg>
                            <span>Filter</span>
                        </button>
                    </div>
                </div>

                <!-- Enhanced Table Container -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm text-left text-gray-700" id="dataTable">
                            <thead class="bg-gradient-to-r from-blue-50 to-indigo-50">
                                <tr>
                                    <th class="px-6 py-4 font-semibold text-blue-900 uppercase text-xs tracking-wider whitespace-nowrap">ID</th>
                                    <th class="px-6 py-4 font-semibold text-blue-900 uppercase text-xs tracking-wider whitespace-nowrap">Nama</th>
                                    <th class="px-6 py-4 font-semibold text-blue-900 uppercase text-xs tracking-wider whitespace-nowrap">Email</th>
                                    <th class="px-6 py-4 font-semibold text-blue-900 uppercase text-xs tracking-wider whitespace-nowrap">NPM</th>
                                    <th class="px-6 py-4 font-semibold text-blue-900 uppercase text-xs tracking-wider whitespace-nowrap">Tahun<br>Lulus</th>
                                    <th class="px-6 py-4 font-semibold text-blue-900 uppercase text-xs tracking-wider whitespace-nowrap">Status Kerja</th>
                                    <th class="px-6 py-4 font-semibold text-blue-900 uppercase text-xs tracking-wider whitespace-nowrap">Dosen Pembimbing</th>

                                    @foreach ($pertanyaans->take(4) as $tanya)
                                        <th data-question @if ($denganFilterPertanyaan) data-question-matched @endif class="px-6 py-4 font-semibold text-blue-900 uppercase text-xs tracking-wider whitespace-nowrap">
                                            {{ $tanya->text }}
                                        </th>
                                    @endforeach

                                    @foreach ($pertanyaans->take(4) as $tanya)
                                        <th class="px-6 py-4 font-semibold text-blue-900 uppercase text-xs tracking-wider whitespace-nowrap hidden">
                                            {{ $tanya->text }}
                                        </th>
                                    @endforeach

                                    <th class="px-6 py-4 font-semibold text-blue-900 uppercase text-xs tracking-wider whitespace-nowrap">Waktu Isi</th>
                                    <th class="px-6 py-4 font-semibold text-blue-900 uppercase text-xs tracking-wider whitespace-nowrap">Lainnya</th>
                                    <th class="px-6 py-4 font-semibold text-blue-900 uppercase text-xs tracking-wider whitespace-nowrap">Aksi</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200 bg-white" id="dataRows">
                                @foreach ($dataAlumni as $index => $row)
                                    <tr class="hover:bg-blue-50 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ ($row['alumni'])->id ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ ($row['alumni'])->nama ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ ($row['alumni'])->email ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ ($row['alumni'])->npm ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ ($row['alumni'])->tahun_lulus ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                {{ ($row['alumni'])->status ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $row['alumni']->dosen_pembimbing ?? '-' }}</td>

                                        @foreach ($pertanyaans->take(4) as $tanya)
                                            <td data-question @if ($denganFilterPertanyaan) data-question-matched @endif class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $row[$tanya->text] ?? ' ' }}
                                            </td>
                                        @endforeach

                                        @foreach ($pertanyaans->take(4) as $tanya)
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 hidden">
                                                {{ $row[$tanya->text] ?? ' ' }}
                                            </td>
                                        @endforeach

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ \Carbon\Carbon::parse($row['tanggal_isi'])->translatedFormat('j F Y, H:i') ?? '-' }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <button 
                                                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-500 text-white text-sm font-medium rounded-lg shadow-md hover:from-blue-600 hover:to-indigo-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75 transition-all duration-200 transform hover:-translate-y-0.5"
                                                onclick="loadDetails({{ $row['id_pengisian'] }})"
                                            >
                                                Detail
                                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path d="M5 12h14M13 6l6 6-6 6" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </button>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <form action="{{ route('admin.alumni_answers.destroy', $row['id_pengisian']) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus data alumni ini beserta jawabannya?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white text-sm font-medium rounded-lg shadow-md hover:from-red-600 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-75 transition-all duration-200 transform hover:-translate-y-0.5">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M19 7L5 7M10 11V17M14 11V17M5 7L6 19C6 20.1 6.9 21 8 21H16C17.1 21 18 20.1 18 19L19 7M9 7V4H15V7" />
                                                    </svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Enhanced No Results Message -->
                <div id="noResults" class="hidden bg-white rounded-2xl shadow-sm border border-red-200 p-8 text-center">
                    <div class="w-16 h-16 bg-red-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Data tidak ditemukan</h3>
                    <p class="text-gray-600">Coba ubah kata kunci pencarian Anda atau reset filter.</p>
                </div>

                <!-- Enhanced Pagination -->
                <div class="mt-8 flex justify-center">
                    {{ $pengisians->links('components.pagination-question') }}
                </div>
            </div>
        </div>
    </div>

  <!-- Lanjutan dari kode yang terputus -->

                <!-- Enhanced Scroll Up Button -->
                <button id="scrollUpBtn" class="fixed bottom-6 right-6 w-12 h-12 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-full shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 opacity-0 pointer-events-none z-40">
                    <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                    </svg>
                </button>

    <!-- Enhanced JavaScript -->
    <script>
        // Global Variables
        let isFilterOpen = false;
        
        // Toggle Filter Sidebar
        function toggleFilter() {
            const sidebar = document.getElementById('filterSidebar');
            const overlay = document.getElementById('overlay');
            
            if (isFilterOpen) {
                // Close Filter
                sidebar.classList.add('translate-x-full');
                overlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
                isFilterOpen = false;
            } else {
                // Open Filter
                sidebar.classList.remove('translate-x-full');
                overlay.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
                isFilterOpen = true;
            }
        }

        // Close filter when clicking overlay
        document.getElementById('overlay').addEventListener('click', function() {
            if (isFilterOpen) {
                toggleFilter();
            }
        });

        // Reset Filter Form
        function resetFilter() {
            document.getElementById('filterKeyword').value = '';
            document.querySelector('input[name="start_date"]').value = '';
            document.querySelector('select[name="tahun_lulus"]').value = 'all';
            document.querySelector('select[name="status_kerja"]').value = 'all';
            
            // Optional: Auto-submit after reset
            // document.querySelector('form').submit();
        }

        // Enhanced Table Search Function
        function searchTable() {
            const input = document.getElementById('tableSearchInput');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('dataTable');
            const tbody = document.getElementById('dataRows');
            const rows = tbody.getElementsByTagName('tr');
            const noResults = document.getElementById('noResults');
            let visibleRows = 0;

            // Show loading state (optional)
            table.style.opacity = '0.7';

            // Add small delay for better UX
            setTimeout(() => {
                for (let i = 0; i < rows.length; i++) {
                    const row = rows[i];
                    const cells = row.getElementsByTagName('td');
                    let shouldShow = false;

                    // Search through all cells in the row
                    for (let j = 0; j < cells.length; j++) {
                        const cellText = cells[j].textContent || cells[j].innerText;
                        if (cellText.toLowerCase().indexOf(filter) > -1) {
                            shouldShow = true;
                            break;
                        }
                    }

                    if (shouldShow || filter === '') {
                        row.style.display = '';
                        row.classList.add('animate-fade-in');
                        visibleRows++;
                    } else {
                        row.style.display = 'none';
                        row.classList.remove('animate-fade-in');
                    }
                }

                // Show/hide no results message
                if (visibleRows === 0 && filter !== '') {
                    noResults.classList.remove('hidden');
                    table.style.display = 'none';
                } else {
                    noResults.classList.add('hidden');
                    table.style.display = 'table';
                }

                // Restore table opacity
                table.style.opacity = '1';
            }, 100);
        }

  const loadDetails = async (pengisianId) => {
    const modal = document.getElementById('detailModal');
    const modalContent = document.getElementById('modalContent');

    const response = await fetch(`/admin/alumni_answers/detail/${pengisianId}`, {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        credentials: 'same-origin'
    });

    const textResponse = await response.text();

    // Show modal with loading state
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    setTimeout(() => {
        modal.style.opacity = '1';
        modal.classList.remove('pointer-events-none');
    }, 10);

    let data;
    let content = ''; // ⬅️ Deklarasi di sini, agar global di fungsi ini
    try {
        data = JSON.parse(textResponse);
    } catch (error) {
        console.error('Gagal parse JSON:', error);
        modalContent.innerHTML = `<p class="text-red-600 p-4">Data tidak valid.</p>`;
        return;
    }

    const alumniLabels = {
        nama: 'Nama Mahasiswa',
        nik: 'NIK',
        email: 'Email',
        npm: 'NPM',
        tahun_lulus: 'Tahun Lulus',
        tanggal_lahir: 'Tanggal Lahir',
        nomor_telepon: 'Nomor Telepon',
        npwp: 'NPWP',
        dosen_pembimbing: 'Dosen Pembimbing',
        pembiayaan: 'Sumber Pembiayaan Kuliah',
        status: 'Status Kerja',
    };

    if (data.alumni) {
        content += `
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 mb-6 border border-blue-200">
                <h4 class="text-lg font-bold text-blue-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Informasi Alumni
                </h4>
                <div class="grid grid-cols-2 gap-4">
                    <div><span class="font-semibold text-gray-700">Nama:</span> <span class="text-gray-900 ml-2">${data.alumni.nama || '-'}</span></div>
                    <div><span class="font-semibold text-gray-700">NPM:</span> <span class="text-gray-900 ml-2">${data.alumni.npm || '-'}</span></div>
                    <div><span class="font-semibold text-gray-700">Email:</span> <span class="text-gray-900 ml-2">${data.alumni.email || '-'}</span></div>
                    <div><span class="font-semibold text-gray-700">Tahun Lulus:</span> <span class="text-gray-900 ml-2">${data.alumni.tahun_lulus || '-'}</span></div>
                    <div><span class="font-semibold text-gray-700">Status:</span> <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 ml-2">${data.alumni.status || '-'}</span></div>
                    <div><span class="font-semibold text-gray-700">Dosen Pembimbing:</span> <span class="text-gray-900 ml-2">${data.alumni.dosen_pembimbing || '-'}</span></div>
                </div>
            </div>
        `;
    }

    // Jawaban Section
    if (data.jawaban && data.jawaban.length > 0) {
        content += `
            <div class="space-y-4">
                <h4 class="text-lg font-bold text-gray-900 flex items-center mb-4">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Jawaban Survei
                </h4>
        `;

        data.jawaban.forEach((item, index) => {
            content += `
                <div class="bg-gray-50 rounded-xl p-5 border border-gray-200 hover:border-gray-300 transition-colors duration-200">
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center text-sm font-semibold flex-shrink-0">
                            ${index + 1}
                        </div>
                        <div class="flex-1">
                            <h5 class="font-semibold text-gray-800 mb-2 leading-relaxed">${item.teks_pertanyaan}</h5>
            `;

            if (item.jenis === 'matrix' && Array.isArray(item.jawaban_baris)) {
                content += `
                    <div class="bg-white rounded-lg p-4 border border-gray-200 space-y-1">
                        ${item.jawaban_baris.map(baris => `
                            <div class="flex justify-between text-gray-700">
                                <span>${baris.baris}</span>
                                <span class="font-medium">${baris.jawaban || '-'}</span>
                            </div>
                        `).join('')}
                    </div>
                `;
            } else {
                content += `
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <p class="text-gray-700 leading-relaxed">${item.jawaban || 'Tidak ada jawaban'}</p>
                    </div>
                `;
            }

            content += `</div></div></div>`;
        });

        content += '</div>';
    }

    if (data.tanggal_isi) {
        content += `
            <div class="mt-6 pt-6 border-t border-gray-200">
                <div class="flex items-center text-sm text-gray-600">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Diisi pada: ${data.tanggal_isi}</span>
                </div>
            </div>
        `;
    }

    modalContent.innerHTML = content;
};


        // Enhanced Modal Functionality
        function closeModal() {
            const modal = document.getElementById('detailModal');
            
            modal.style.opacity = '0';
            modal.classList.add('pointer-events-none');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }

        // Close modal when clicking outside
        document.getElementById('detailModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Scroll Up Button Functionality
        function initScrollUpButton() {
            const scrollUpBtn = document.getElementById('scrollUpBtn');
            
            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 300) {
                    scrollUpBtn.style.opacity = '1';
                    scrollUpBtn.classList.remove('pointer-events-none');
                } else {
                    scrollUpBtn.style.opacity = '0';
                    scrollUpBtn.classList.add('pointer-events-none');
                }
            });

            scrollUpBtn.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        }

        // Enhanced Animation Utilities
        function addFadeInAnimation() {
            const style = document.createElement('style');
            style.textContent = `
                .animate-fade-in {
                    animation: fadeIn 0.3s ease-in-out;
                }
                
                @keyframes fadeIn {
                    from {
                        opacity: 0;
                        transform: translateY(10px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }
                
                .scrollbar-thin::-webkit-scrollbar {
                    width: 6px;
                }
                
                .scrollbar-thin::-webkit-scrollbar-track {
                    background: #f1f5f9;
                    border-radius: 3px;
                }
                
                .scrollbar-thin::-webkit-scrollbar-thumb {
                    background: #cbd5e1;
                    border-radius: 3px;
                }
                
                .scrollbar-thin::-webkit-scrollbar-thumb:hover {
                    background: #94a3b8;
                }
            `;
            document.head.appendChild(style);
        }

        // Keyboard Shortcuts
        function initKeyboardShortcuts() {
            document.addEventListener('keydown', function(e) {
                // Escape key to close modals and filters
                if (e.key === 'Escape') {
                    if (document.getElementById('detailModal').style.opacity === '1') {
                        closeModal();
                    } else if (isFilterOpen) {
                        toggleFilter();
                    }
                }
                
                // Ctrl/Cmd + K to focus search
                if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                    e.preventDefault();
                    document.getElementById('tableSearchInput').focus();
                }
                
                // Ctrl/Cmd + F to open filter
                if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
                    e.preventDefault();
                    if (!isFilterOpen) {
                        toggleFilter();
                    }
                }
            });
        }

        // Initialize everything when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            initScrollUpButton();
            addFadeInAnimation();
            initKeyboardShortcuts();
            
            // Auto-focus search input for better UX
            const searchInput = document.getElementById('tableSearchInput');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    // Debounce search for better performance
                    clearTimeout(this.searchTimeout);
                    this.searchTimeout = setTimeout(searchTable, 300);
                });
            }
            
            // Add loading states to buttons
            const detailButtons = document.querySelectorAll('[onclick^="loadDetails"]');
            detailButtons.forEach(button => {
                button.addEventListener('click', function() {
                    this.disabled = true;
                    this.innerHTML = `
                        <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-white mr-2"></div>
                        Loading...
                    `;
                    
                    // Re-enable button after 3 seconds (fallback)
                    setTimeout(() => {
                        this.disabled = false;
                        this.innerHTML = `
                            Detail
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M5 12h14M13 6l6 6-6 6" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        `;
                    }, 3000);
                });
            });
        });

        // Export functions for potential external use
        window.AlumniAnswers = {
            toggleFilter,
            resetFilter,
            searchTable,
            loadDetails,
            closeModal
        };
    </script>

    <!-- Additional CSS for enhanced styling -->
    <style>
        /* Custom scrollbar for webkit browsers */
        .scrollbar-thin {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 #f1f5f9;
        }
        
        /* Smooth transitions for all interactive elements */
        * {
            transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Enhanced hover effects for table rows */
        tbody tr:hover {
            background-color: #eff6ff;
            transform: translateX(2px);
        }
        
        /* Loading animation for buttons */
        .btn-loading {
            position: relative;
            pointer-events: none;
        }
        
        .btn-loading::after {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            margin: auto;
            border: 2px solid transparent;
            border-top-color: #ffffff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Enhanced focus states */
        input:focus, select:focus, button:focus {
            outline: none;
            ring: 2px;
            ring-color: #3b82f6;
            ring-opacity: 0.5;
        }
        
        /* Improved modal backdrop */
        #detailModal {
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }
        
        /* Enhanced card shadows */
        .card-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        .card-shadow:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
    </style>
</x-app-layout>