<x-app-layout>
  <x-slot name="header">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
      <div>
        <h1 class="text-2xl font-semibold text-gray-900">Dashboard Alumni Teknik Informatika</h1>
        <p class="mt-1 text-sm text-gray-500">Analisis karir alumni program studi Teknik Informatika</p>
      </div>
      <form method="GET" action="{{ route('admin.dashboard') }}" class="flex gap-2">
        <select name="tahun" class="border border-gray-300 rounded-lg text-sm py-2 px-3">
          <option value="">Semua Tahun</option>
          @foreach ($tahunOptions as $t)
        <option value="{{ $t }}" {{ request('tahun') == $t ? 'selected' : '' }}>{{ $t }}</option>
      @endforeach
        </select>
        <select name="status" class="border border-gray-300 rounded-lg text-sm py-2 px-3">
          <option value="">Semua Status</option>
          <option value="Bekerja" {{ request('status') == 'Bekerja' ? 'selected' : '' }}>Bekerja</option>
          <option value="Wiraswasta" {{ request('status') == 'Wiraswasta' ? 'selected' : '' }}>Wiraswasta</option>
          <option value="Melanjutkan Studi" {{ request('status') == 'Melanjutkan Studi' ? 'selected' : '' }}>Melanjutkan
            Studi</option>
          <option value="Mencari Kerja" {{ request('status') == 'Mencari Kerja' ? 'selected' : '' }}>Mencari Kerja
          </option>
        </select>
        <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">Terapkan</button>
      </form>
    </div>
  </x-slot>

  <div class="bg-gray-50 py-6 px-4 text-gray-800">
    <div class="max-w-7xl mx-auto space-y-6">

      <!-- Ringkasan -->
      <div class="flex flex-wrap gap-5">
        <div class="flex-1 min-w-[200px] max-w-sm">
          <x-summary-card label="Total Alumni" :value="$alumni" icon="users" color="blue" />
        </div>
        <div class="flex-1 min-w-[200px] max-w-sm">
          <x-summary-card label="Alumni Bekerja" :value="$alumniBekerja" icon="briefcase" color="green" />
        </div>
        <div class="flex-1 min-w-[200px] max-w-sm">
          <x-summary-card label="Rata-rata Gaji" :value="$gajiAvg ? 'Rp' . number_format($gajiAvg, 0, ',', '.') : 'N/A'"
            icon="money-bill-wave" color="purple" />
        </div>
              
      </div>

      <!-- Chart 1 & 2 -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow border">
          <h3 class="text-lg font-semibold mb-4">Distribusi Status Pekerjaan Alumni</h3>
          <div class="relative h-[250px] overflow-x-auto">
            <canvas id="statusChart" class="h-full w-full min-w-[300px]"></canvas>
          </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow border">
          <h3 class="text-lg font-semibold mb-4">Alumni per Angkatan</h3>
          <div class="relative h-[250px] overflow-x-auto">
            <canvas id="angkatanChart" class="h-full w-full min-w-[300px]"></canvas>
          </div>
        </div>
      </div>

      <!-- Chart 3 & Top Perusahaan -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-xl shadow border">
          <h3 class="text-lg font-semibold mb-4">Top 5 Perusahaan dengan Alumni Terbanyak</h3>
          <ul class="divide-y divide-gray-100 text-sm">
            @forelse ($topPerusahaan as $i => $p)
        <li class="py-2 flex justify-between">
          <span>{{ $i + 1 }}. {{ $p->nama_perusahaan }}</span>
          <span class="text-gray-500">{{ $p->total }} alumni</span>
        </li>
      @empty
        <li class="py-2 text-gray-400">Belum ada data perusahaan</li>
      @endforelse
          </ul>
        </div>

        <div class="bg-white p-6 rounded-xl shadow border">
          <h3 class="text-lg font-semibold mb-4">Tren Gaji Rata-rata per Tahun</h3>
          <div class="relative h-[250px] overflow-x-auto">
            <canvas id="gajiChart" class="h-full w-full min-w-[300px]"></canvas>
          </div>
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
</x-app-layout>