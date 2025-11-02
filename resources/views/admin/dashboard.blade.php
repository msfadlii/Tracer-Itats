<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center space-x-4">
      <div class="flex-shrink-0">
        <div
          class="h-12 w-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
          <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
          </svg>
        </div>
      </div>
      <div>
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
          Dashboard Alumni
        </h2>
        <p class="text-sm text-gray-600 mt-1">Analisis karir alumni program studi Teknik Informatika</p>
      </div>
    </div>
  </x-slot>

  <div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

      <!-- Reset Filter Success Notification -->
      @if (session('filter_reset'))
        <div id="filterResetToast" class="fixed top-4 right-4 z-50 max-w-sm w-full sm:max-w-md">
          <div role="alert" aria-live="assertive" aria-atomic="true"
            class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-lg shadow-lg flex items-start space-x-3"
            style="animation: slideInFromRight 260ms ease-out;">
            <div class="flex-shrink-0">
              <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                  d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z"
                  clip-rule="evenodd" />
              </svg>
            </div>
            <div class="flex-1">
              <div class="flex items-start justify-between">
                <h3 class="text-sm font-medium text-blue-800">Filter Direset!</h3>
                <button id="closeFilterResetToast" type="button"
                  class="ml-4 text-blue-600 hover:text-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-300 rounded">
                  <span class="sr-only">Tutup notifikasi</span>
                  <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </button>
              </div>
              <div class="mt-2 text-sm text-blue-700">
                {{ session('filter_reset') }}
              </div>
            </div>
          </div>
        </div>
      @endif

      <!-- Filter Section -->
      <div class="bg-white shadow-lg rounded-xl border border-gray-100 p-6 mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
          <div>
            <h3 class="text-lg font-semibold text-gray-800">Filter Data</h3>
            <p class="text-sm text-gray-600">Pilih tahun dan status untuk melihat data spesifik</p>
          </div>
          <form method="GET" action="{{ route('admin.dashboard') }}" class="flex flex-wrap gap-3">
            <div class="flex flex-col">
              <label class="text-xs font-medium text-gray-600 mb-1">Tahun Lulus</label>
              <select name="tahun"
                class="border border-gray-300 rounded-lg text-sm py-2.5 px-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                <option value="">Semua Tahun</option>
                @foreach ($tahunOptions as $t)
                  <option value="{{ $t }}" {{ request('tahun') == $t ? 'selected' : '' }}>{{ $t }}</option>
                @endforeach
              </select>
            </div>
            <div class="flex flex-col">
              <label class="text-xs font-medium text-gray-600 mb-1">Status Kerja</label>
              <select name="status"
                class="border border-gray-300 rounded-lg text-sm py-2.5 px-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                <option value="">Semua Status</option>
                <option value="Bekerja" {{ request('status') == 'Bekerja' ? 'selected' : '' }}>Bekerja</option>
                <option value="Wiraswasta" {{ request('status') == 'Wiraswasta' ? 'selected' : '' }}>Wiraswasta</option>
                <option value="Melanjutkan Studi" {{ request('status') == 'Melanjutkan Studi' ? 'selected' : '' }}>
                  Melanjutkan Studi</option>
                <option value="Mencari Kerja" {{ request('status') == 'Mencari Kerja' ? 'selected' : '' }}>Mencari Kerja
                </option>
                <option value="belum memungkinkan bekerja" {{ request('status') == 'belum memungkinkan bekerja' ? 'selected' : '' }}>Belum Memungkinkan Bekerja</option>
              </select>
            </div>
            <div class="flex flex-col justify-end">
              <div class="flex gap-2">
                <button type="submit"
                  class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 flex items-center space-x-2">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.707A1 1 0 013 7V4z" />
                  </svg>
                  <span>Terapkan Filter</span>
                </button>
                <a href="{{ route('admin.dashboard') }}"
                  class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 flex items-center space-x-2">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                  </svg>
                  <span>Reset</span>
                </a>
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-- Summary Statistics -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-lg overflow-hidden">
          <div class="p-6 text-white">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-blue-100 text-sm font-medium">Total Alumni</p>
                <p class="text-3xl font-bold">{{ $alumni }}</p>
                <p class="text-blue-100 text-sm mt-1">Terdaftar dalam sistem</p>
              </div>
              <div class="h-16 w-16 bg-white/20 rounded-full flex items-center justify-center">
                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                </svg>
              </div>
            </div>
          </div>
        </div>

        <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-xl shadow-lg overflow-hidden">
          <div class="p-6 text-white">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-emerald-100 text-sm font-medium">Alumni Bekerja</p>
                <p class="text-3xl font-bold">{{ $alumniBekerja }}</p>
                <p class="text-emerald-100 text-sm mt-1">
                  {{ $alumni > 0 ? number_format(($alumniBekerja / $alumni) * 100, 1) : 0 }}% dari total alumni
                </p>
              </div>
              <div class="h-16 w-16 bg-white/20 rounded-full flex items-center justify-center">
                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 112 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 112-2V6z" />
                </svg>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Charts Section -->
      <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-8">
        <!-- Status Pekerjaan Chart -->
        <div class="xl:col-span-2 bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
          <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
            <div class="flex items-center space-x-3">
              <div class="h-8 w-8 bg-blue-500 rounded-lg flex items-center justify-center">
                <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
              </div>
              <h3 class="text-lg font-semibold text-gray-800">Distribusi Status Pekerjaan Alumni</h3>
            </div>
          </div>
          <div class="p-6">
            <div class="relative h-[280px] overflow-x-auto">
              <canvas id="statusChart" class="h-full w-full min-w-[300px]"></canvas>
            </div>
          </div>
        </div>

        <!-- Alumni per Angkatan Chart -->
        <div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
          <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
            <div class="flex items-center space-x-3">
              <div class="h-8 w-8 bg-indigo-500 rounded-lg flex items-center justify-center">
                <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
              </div>
              <h3 class="text-lg font-semibold text-gray-800">Alumni per Angkatan</h3>
            </div>
          </div>
          <div class="p-6">
            <div class="relative h-[280px] overflow-x-auto">
              <canvas id="angkatanChart" class="h-full w-full min-w-[300px]"></canvas>
            </div>
          </div>
        </div>
      </div>

      <!-- Top Companies Section -->
      <div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
          <div class="flex items-center space-x-3">
            <div class="h-8 w-8 bg-emerald-500 rounded-lg flex items-center justify-center">
              <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
              </svg>
            </div>
            <div>
              <h3 class="text-lg font-semibold text-gray-800">Top 5 Perusahaan dengan Alumni Terbanyak</h3>
              <p class="text-sm text-gray-600">Perusahaan favorit alumni berdasarkan jumlah karyawan</p>
            </div>
          </div>
        </div>
        <div class="p-6">
          @if($topPerusahaan->isNotEmpty())
            <div class="space-y-4">
              @foreach ($topPerusahaan as $i => $p)
                <div
                  class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-100 hover:bg-gray-100 transition-colors">
                  <div class="flex items-center space-x-4">
                    <div
                      class="h-10 w-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                      <span class="text-white font-bold text-sm">{{ $i + 1 }}</span>
                    </div>
                    <div>
                      <h4 class="font-semibold text-gray-800">{{ $p->nama_perusahaan }}</h4>
                      <p class="text-sm text-gray-600">{{ $p->total }} alumni bekerja</p>
                    </div>
                  </div>
                  <div class="flex items-center space-x-2">
                    <div class="h-2 w-20 bg-gray-200 rounded-full overflow-hidden">
                      <div class="h-full bg-gradient-to-r from-blue-500 to-blue-600 rounded-full"
                        style="width: {{ ($p->total / $topPerusahaan->first()->total) * 100 }}%"></div>
                    </div>
                    <span class="text-sm font-medium text-gray-700">{{ $p->total }}</span>
                  </div>
                </div>
              @endforeach
            </div>
          @else
            <div class="text-center py-12">
              <div class="mx-auto h-16 w-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
              </div>
              <p class="text-gray-500 text-sm">Belum ada data perusahaan</p>
            </div>
          @endif
        </div>
      </div>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const colors = {
        primary: '#3B82F6',
        success: '#10B981',
        warning: '#F59E0B',
        danger: '#EF4444',
        info: '#6366F1',
        dark: '#1F2937'
      };

      const statusData = @json($distribusiStatus);
      const angkatanData = @json($alumniPerTahun);
      const gajiData = @json($gajiPerTahun);

      new Chart(document.getElementById('statusChart'), {
        type: 'bar',
        data: {
          labels: statusData.map(s => s.status),
          datasets: [{
            label: 'Jumlah Alumni',
            data: statusData.map(s => s.total),
            backgroundColor: [colors.primary, colors.success, colors.info, colors.warning, colors.danger],
            borderRadius: 4
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: { legend: { display: false } },
          scales: {
            y: { beginAtZero: true, ticks: { color: '#6B7280' } },
            x: { ticks: { color: '#6B7280' } }
          }
        }
      });

      new Chart(document.getElementById('angkatanChart'), {
        type: 'line',
        data: {
          labels: angkatanData.map(a => a.tahun_lulus),
          datasets: [{
            label: 'Jumlah Alumni',
            data: angkatanData.map(a => a.total),
            borderColor: colors.primary,
            backgroundColor: 'rgba(59, 130, 246, 0.05)',
            fill: true,
            tension: 0.4,
            borderWidth: 2,
            pointBackgroundColor: colors.primary
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: { legend: { display: false } },
          scales: {
            y: { beginAtZero: false, ticks: { color: '#6B7280' } },
            x: { ticks: { color: '#6B7280' } }
          }
        }
      });

      new Chart(document.getElementById('gajiChart'), {
        type: 'line',
        data: {
          labels: gajiData.map(g => g.tahun),
          datasets: [{
            label: 'Gaji Rata-rata',
            data: gajiData.map(g => g.rata),
            borderColor: colors.success,
            backgroundColor: 'rgba(16, 185, 129, 0.05)',
            fill: true,
            tension: 0.4,
            borderWidth: 2,
            pointBackgroundColor: colors.success
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: { legend: { display: false } },
          scales: {
            y: { beginAtZero: false, ticks: { color: '#6B7280' } },
            x: { ticks: { color: '#6B7280' } }
          }
        }
      });
    });
  </script>

  <!-- Filter Reset Toast Styles and Script -->
  <style>
    @keyframes slideInFromRight {
      from {
        opacity: 0;
        transform: translateX(12px);
      }

      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    @media (max-width: 480px) {
      #filterResetToast {
        left: 12px !important;
        right: 12px !important;
        top: 12px !important;
        max-width: calc(100% - 24px) !important;
      }
    }
  </style>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Filter reset toast handling
      const filterResetToast = document.getElementById('filterResetToast');
      const closeFilterResetToastBtn = document.getElementById('closeFilterResetToast');

      if (filterResetToast) {
        // Auto-hide after 4 seconds
        const hideFilterResetTimeout = setTimeout(() => {
          filterResetToast.style.transition = 'opacity 220ms ease-out, transform 220ms ease-out';
          filterResetToast.style.opacity = '0';
          filterResetToast.style.transform = 'translateX(8px)';
          setTimeout(() => filterResetToast.remove(), 240);
        }, 4000);

        if (closeFilterResetToastBtn) {
          closeFilterResetToastBtn.addEventListener('click', function () {
            clearTimeout(hideFilterResetTimeout);
            filterResetToast.style.transition = 'opacity 160ms ease-out, transform 160ms ease-out';
            filterResetToast.style.opacity = '0';
            filterResetToast.style.transform = 'translateX(8px)';
            setTimeout(() => filterResetToast.remove(), 180);
          });
        }
      }
    });
  </script>
</x-app-layout>