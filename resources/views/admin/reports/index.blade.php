
<x-app-layout>
    <x-slot name="header">
        <div class="mb-6 flex items-start gap-4 animate-fancy-in">
            <div class="border-l-4 border-blue-600 pl-4">
                <h2 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-chart-bar text-blue-600"></i>
                    Laporan Statistik
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    Visualisasi data lulusan berdasarkan tahun, status pekerjaan, dan tipe grafik yang dipilih.
                </p>
            </div>
        </div>
    </x-slot>

    <!-- Head CDN -->
    <x-slot name="head">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />

        <style>
            .choices__inner {
                background-color: #f9fafb !important;
                color: #1f2937 !important;
                border: 1px solid #d1d5db !important;
            }

            .choices__list--multiple .choices__item {
                background-color: #3b82f6 !important;
                border: none !important;
                color: white;
                font-size: 0.875rem;
                padding: 0.3rem 0.75rem;
                border-radius: 0.375rem;
                margin: 0.2rem 0.3rem;
            }

            .choices__list--dropdown {
                background-color: #ffffff !important;
                color: #1f2937;
            }

            .choices__input {
                background-color: transparent !important;
                color: #1f2937 !important;
            }

            .choices[data-type*="select-multiple"] .choices__button {
                color: #1f2937 !important;
            }

            .choices__list--dropdown .choices__item--selectable::before {
                content: '';
                display: inline-block;
                width: 1rem;
                height: 1rem;
                margin-right: 0.75rem;
                border: 2px solid #9ca3af;
                border-radius: 0.2rem;
                background-color: transparent;
                vertical-align: middle;
            }

            .choices__list--dropdown .choices__item--selectable.is-highlighted::before {
                border-color: #3b82f6;
            }

            .choices__list--dropdown .choices__item--selectable[data-value].choices__item--selectable--checked::before {
                background-color: #3b82f6;
                border-color: #3b82f6;
                box-shadow: inset 0 0 0 2px #ffffff;
            }

            .choices__list--dropdown .choices__item--selectable {
                padding-left: 1.5rem;
                color: #1f2937;
            }

            /* Custom styling untuk dropdown tahun */
            .year-dropdown-container {
                position: relative;
            }

            .year-dropdown {
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                z-index: 9999;
                margin-top: 0.25rem;
                max-height: 20rem;
                overflow-y: auto;
                background: white;
                border: 1px solid #d1d5db;
                border-radius: 0.5rem;
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            }

            /* Pastikan container form memiliki overflow visible */
            .form-container {
                overflow: visible !important;
            }

            /* Responsif untuk dropdown */
            @media (max-width: 640px) {
                .year-dropdown {
                    position: fixed;
                    top: auto;
                    bottom: 0;
                    left: 1rem;
                    right: 1rem;
                    max-height: 50vh;
                    border-radius: 1rem 1rem 0 0;
                }
            }
        </style>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-white via-gray-50 to-white text-gray-900 py-6 px-4 sm:px-6 lg:px-8 transition-all duration-300">
        <div class="w-full space-y-10 transition-all duration-300">

            <!-- FILTER PANEL -->
            <div class="bg-white bg-opacity-90 backdrop-blur-md rounded-2xl p-6 shadow-lg">
                <div class="w-full form-container" style="overflow: visible;">
                   
                    <form method="GET" action="{{ route('admin.reports.showReport') }}"
                        class="space-y-6 w-full relative">

                        <!-- Row 1: Jenis Chart dan Tahun Lulus -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            {{-- Jenis Chart --}}
                            <div class="flex flex-col">
                                <label for="chart_type" class="mb-2 text-sm font-semibold text-gray-700">Jenis Chart</label>
                                <select name="chart_type" id="chart_type"
                                    class="bg-white text-gray-900 border border-gray-300 rounded-md px-4 py-3 shadow-sm 
                                        focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                    <option value="line" {{ request('chart_type') == 'line' ? 'selected' : '' }}>Line</option>
                                    <option value="bar" {{ request('chart_type') == 'bar' ? 'selected' : '' }}>Bar</option>
                                    <option value="pie" {{ request('chart_type') == 'pie' ? 'selected' : '' }}>Pie</option>
                                </select>
                            </div>

                            {{-- Tahun Lulus --}}
                            <div class="flex flex-col year-dropdown-container" x-data="multiYear()" x-cloak>
                                <label class="mb-2 text-sm font-semibold text-gray-700">Tahun Lulus</label>

                                {{-- Debug info (hapus setelah testing) --}}
                                {{-- <div class="mb-2 p-2 bg-yellow-50 text-xs rounded" x-show="true">
                                    <strong>Debug:</strong> 
                                    <span x-text="'Selected: ' + JSON.stringify(selected)"></span><br>
                                    <span x-text="'All Years: ' + JSON.stringify(allYears)"></span>
                                </div> --}}

                                <div class="relative">
                                    <button @click="open = !open" type="button"
                                        class="w-full flex justify-between items-center bg-white text-gray-900 border border-gray-300 rounded-md px-4 py-3 shadow-sm
                                        focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                                        <span x-text="selected.length ? `${selected.length} tahun dipilih` : 'Pilih Tahun'"></span>
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-gray-500 transition-transform duration-300"
                                            :class="{'rotate-180': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>

                                    <div x-show="open" @click.away="open = false"
                                        class="absolute z-50 mt-2 w-full bg-white border border-gray-200 rounded-md shadow-lg year-dropdown"
                                        x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0 transform scale-95"
                                        x-transition:enter-end="opacity-100 transform scale-100"
                                        x-transition:leave="transition ease-in duration-150"
                                        x-transition:leave-start="opacity-100 transform scale-100"
                                        x-transition:leave-end="opacity-0 transform scale-95"
                                    >

                                        {{-- Search --}}
                                        <div class="p-3 border-b border-gray-200 bg-gray-50">
                                            <input x-model="search" type="text" placeholder="Cari tahun..." 
                                                class="w-full bg-white text-gray-900 border border-gray-300 rounded-md px-3 py-2
                                                focus:outline-none focus:ring-2 focus:ring-blue-500 transition text-sm" />
                                        </div>

                                        {{-- Options --}}
                                        <div class="max-h-48 overflow-y-auto">
                                            <ul class="divide-y divide-gray-200">
                                                <template x-for="year in filtered" :key="year">
                                                    <li @click="toggle(year)"
                                                        class="flex items-center px-4 py-3 cursor-pointer hover:bg-blue-50 select-none transition-colors">
                                                        <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 rounded"
                                                            :checked="isSelected(year)" @click.stop="toggle(year)" />
                                                        <span class="ml-3 text-gray-900 text-sm" x-text="year"></span>
                                                    </li>
                                                </template>
                                                <template x-if="filtered.length === 0">
                                                    <li class="px-4 py-3 text-gray-500 italic text-sm text-center">Tidak ada hasil</li>
                                                </template>
                                            </ul>
                                        </div>

                                        {{-- Footer --}}
                                        <div class="flex justify-between items-center px-4 py-3 border-t border-gray-200 bg-gray-50">
                                            <button @click="selectAll()" type="button"
                                                class="text-blue-600 hover:text-blue-800 hover:underline focus:outline-none text-sm font-medium">
                                                Pilih Semua
                                            </button>
                                            <button @click="reset()" type="button"
                                                class="text-red-600 hover:text-red-800 hover:underline focus:outline-none text-sm font-medium">
                                                Reset
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                {{-- Hidden inputs --}}
                                <template x-for="year in selected" :key="year">
                                    <input type="hidden" name="graduation_year[]" :value="year" />
                                </template>
                            </div>

                        <!-- Row 2: Halaman Kuesioner dan Pertanyaan -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            {{-- Halaman Kuesioner --}}
                            <div class="flex flex-col">
                                <label for="halaman_id" class="mb-2 text-sm font-semibold text-gray-700">Kategori (Halaman)</label>
                                <select name="halaman_id" id="halaman_id"
                                    class="bg-white text-gray-900 border border-gray-300 rounded-md px-4 py-3 shadow-sm
                                        focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                    onchange="this.form.submit()">
                                    <option value="" disabled {{ empty($halamanId) ? 'selected' : '' }}>-- Pilih Halaman --</option>
                                    @foreach ($halamanKuesioners as $halaman)
                                        <option value="{{ $halaman->id }}" {{ ($halamanId == $halaman->id) ? 'selected' : '' }}>
                                            {{ $halaman->judul }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Subkategori: Pertanyaan --}}
                            @if ($pertanyaans->isNotEmpty())
                                <div class="flex flex-col">
                                    <label for="pertanyaan_id" class="mb-2 text-sm font-semibold text-gray-700">Pilih Pertanyaan</label>
                                    <select name="pertanyaan_id" id="pertanyaan_id"
                                        class="bg-white text-gray-900 border border-gray-300 rounded-md px-4 py-3 shadow-sm
                                            focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                        onchange="this.form.submit()">
                                        <option value="" disabled {{ empty($pertanyaanId) ? 'selected' : '' }}>-- Pilih Pertanyaan --</option>
                                        @foreach ($pertanyaans as $pertanyaan)
                                            <option value="{{ $pertanyaan->id }}" {{ ($pertanyaanId == $pertanyaan->id) ? 'selected' : '' }}>
                                                {{ $pertanyaan->teks }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <div class="flex flex-col">
                                    <label class="mb-2 text-sm font-semibold text-gray-400">Pilih Pertanyaan</label>
                                    <div class="bg-gray-100 text-gray-500 border border-gray-200 rounded-md px-4 py-3 text-center italic">
                                        Pilih halaman terlebih dahulu
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Tombol Submit - Selalu Tampil --}}
                        <div class="flex justify-center pt-4 border-t border-gray-200">
                            <button type="submit"
                                class="w-full sm:w-auto min-w-[200px] bg-gradient-to-r from-blue-600 to-blue-800 text-white font-semibold px-8 py-3 rounded-lg shadow-lg
                                    hover:from-blue-700 hover:to-blue-900 focus:outline-none focus:ring-4 focus:ring-blue-500 transition-all duration-200
                                    transform hover:scale-105 active:scale-95">
                                <i class="fa-solid fa-magnifying-glass mr-2"></i> 
                                Tampilkan Data
                            </button>
                        </div>

                    </form>

                </div>

                <!-- No Data Message -->
                <div id="no-data-message"
                    class="hidden mt-6 px-6 py-4 rounded-xl bg-yellow-100 text-gray-900 text-center text-lg font-semibold shadow-md">
                    Tidak ada data yang tersedia dengan filter yang dipilih.
                </div>

                <!-- CHART CONTAINER -->
                <div id="chart-container" class="w-full overflow-x-auto mt-6">
                    <div class="relative w-full">
                        <canvas id="chart" class="!w-full h-[300px] sm:h-[400px] md:h-[500px] lg:h-[600px]"></canvas>
                    </div>
                </div>

                <!-- DOWNLOAD SECTION -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 w-full flex-wrap mt-10">
                    <div class="flex items-center space-x-4">
                        <label class="font-medium text-sm text-gray-700">Format Download</label>
                        <select id="download_format"
                            class="flex-1 bg-white text-gray-800 border border-gray-300 rounded-lg ml-4 px-6 py-2 focus:ring-2 focus:ring-green-400 shadow-sm">
                            <option>PNG</option>
                            <option>JPEG</option>
                            <option>WebP</option>
                            <option>PDF</option>
                        </select>
                    </div>

                    <div class="flex gap-4">
                        <button id="download-btn"
                            class="flex items-center bg-green-500 hover:bg-green-600 text-white px-5 py-3 rounded-xl shadow-md transition-transform hover:scale-105">
                            <i class="fa-solid fa-download mr-2"></i> Download Grafik
                        </button>
                        <button onclick="window.print()"
                            class="flex items-center bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-3 rounded-xl shadow-md transition-transform hover:scale-105">
                            <i class="fa-solid fa-print mr-2"></i> Cetak Laporan
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        const datalabels = @json($chartLabels);
        const datacounts = @json($chartCounts);
        const selectedStatus = @json($selectedStatus ?? 'semua');
        const selectedCategory = @json($category ?? '');
        const selectedSubcategory = @json($subcategory ?? '');
        let chart;

        function toggleDownloadButton(isDisabled) {
            const downloadBtn = document.getElementById('download-btn');
            if (!downloadBtn) return;
            downloadBtn.disabled = isDisabled;
            downloadBtn.classList.toggle('opacity-50', isDisabled);
        }

        function renderChart(type) {
            const ctx = document.getElementById('chart').getContext('2d');
            const noDataMessage = document.getElementById('no-data-message');
            const canvas = document.getElementById('chart');

            if (chart) {
                chart.destroy();
            }

            const isEmpty = !Array.isArray(datacounts) || datacounts.length === 0 || datacounts.every(c => c === 0);

            if (isEmpty) {
                canvas.style.display = 'none';
                noDataMessage.classList.remove('hidden');
                toggleDownloadButton(true);
                return;
            } else {
                canvas.style.display = 'block';
                noDataMessage.classList.add('hidden');
                toggleDownloadButton(false);
            }

            let chartLabel = 'Jumlah';

            if (selectedCategory) {
                chartLabel += ` - ${selectedCategory.replace(/_/g, ' ')}`;
            }
            if (selectedSubcategory) {
                chartLabel += ` | ${selectedSubcategory}`;
            }
            if (selectedStatus && selectedStatus !== 'semua') {
                chartLabel += ` | Status: ${selectedStatus}`;
            }

            const colors = ['#3B82F6', '#9333EA', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6', '#A3A3A3', '#F472B6'];
            const singleColor = '#3B82F6';

            const datasetConfig = {
                label: chartLabel,
                data: datacounts,
                borderColor: singleColor,
                backgroundColor: type === 'line' ? 'transparent' : colors,
                fill: false,
                tension: 0.3,
                pointBackgroundColor: singleColor,
                pointBorderColor: '#fff',
                borderWidth: 3
            };

            chart = new Chart(ctx, {
                type: type,
                data: {
                    labels: datalabels,
                    datasets: [datasetConfig]
                },
                options: {
                    responsive: true,
                    animation: { duration: 1000, easing: 'easeOutBounce' },
                    plugins: {
                        legend: { labels: { color: '#374151' } },
                        tooltip: {
                            backgroundColor: '#f9fafb',
                            titleColor: '#1f2937',
                            bodyColor: '#1f2937'
                        }
                    },
                    scales: {
                        x: {
                            ticks: { color: '#4B5563' },
                            grid: { color: 'rgba(0,0,0,0.05)' }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: { color: '#4B5563' },
                            grid: { color: 'rgba(0,0,0,0.05)' }
                        }
                    }
                }
            });
        }

        const chartTypeSelect = document.getElementById('chart_type');
        if (chartTypeSelect) {
            chartTypeSelect.value = '{{ $chartType }}';
                renderChart('{{ $chartType }}');


            chartTypeSelect.addEventListener('change', function () {
                renderChart(this.value);
            });
        } else {
            renderChart('bar');
        }

        document.getElementById('download-btn').addEventListener('click', function () {
            let format = document.getElementById('download_format').value.toLowerCase();
            const canvas = document.getElementById('chart');

            if (format === 'pdf') {
                const { jsPDF } = window.jspdf;
                const pdf = new jsPDF('landscape');
                const imgData = canvas.toDataURL('image/png');
                const pageWidth = pdf.internal.pageSize.getWidth();
                const pageHeight = pdf.internal.pageSize.getHeight();
                pdf.addImage(imgData, 'PNG', 10, 10, pageWidth - 20, pageHeight - 20);
                pdf.save('chart.pdf');
            } else {
                const validFormats = ['png', 'jpeg', 'webp'];
                if (!validFormats.includes(format)) {
                    alert('Format tidak didukung untuk gambar.');
                    return;
                }
                const mimeType = `image/${format}`;
                const dataUrl = canvas.toDataURL(mimeType);
                const link = document.createElement('a');
                link.href = dataUrl;
                link.download = `chart.${format}`;
                link.click();
            }
        });

        function multiYear() {
            return {
                open: false,
                allYears: @json($graduationYears),
                selected: [],
                search: '',
                
                init() {
                    // Ambil data dari server
                    const serverSelected = @json($selectedYears ?? []);
                    console.log('Server selected:', serverSelected);
                    console.log('All years:', this.allYears);
                    
                    // Pastikan selected adalah array dan berisi integer
                    this.selected = Array.isArray(serverSelected) ? 
                        serverSelected.map(year => parseInt(year)) : 
                        [];
                        
                    console.log('Final selected:', this.selected);
                },
                
                get filtered() {
                    return this.allYears.filter(year =>
                        year.toString().includes(this.search.toLowerCase())
                    );
                },
                
                isSelected(year) {
                    const isSelected = this.selected.includes(parseInt(year));
                    console.log(`Year ${year} is selected:`, isSelected);
                    return isSelected;
                },
                
                toggle(year) {
                    const yearInt = parseInt(year);
                    if (this.selected.includes(yearInt)) {
                        this.selected = this.selected.filter(y => y !== yearInt);
                    } else {
                        this.selected.push(yearInt);
                    }
                    console.log('Selected after toggle:', this.selected);
                },
                
                selectAll() {
                    this.selected = [...this.allYears];
                },
                
                reset() {
                    this.selected = [];
                    this.search = '';
                }
            }
        }

        window.addEventListener('resize', () => {
            if (chart) {
                chart.resize();
            }
        });
    </script>
</x-app-layout>