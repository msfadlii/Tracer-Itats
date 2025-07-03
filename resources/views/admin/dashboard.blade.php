<x-app-layout>
  <x-slot name="header">
    <div class="mb-6 flex flex-col gap-2 animate-fancy-in">
      <div class="flex items-center gap-3">
        <i class="fas fa-tachometer-alt text-blue-600 text-3xl"></i>
        <div>
          <h2 class="text-3xl font-bold text-gray-800">
            Dashboard Alumni
          </h2>
          <p class="text-sm text-gray-600 mt-1">
            Selamat datang di panel kontrol alumni, kelola data dan informasi dengan mudah.
          </p>
        </div>
      </div>
      <div class="border-b-2 border-blue-600 w-32"></div>
    </div>
  </x-slot>

  <div class="bg-gray-50 min-h-screen py-8 text-gray-800">
    <div class="max-w-7xl mx-auto px-4">

      <!-- Statistik Cards -->
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white border-l-4 border-indigo-500 p-6 rounded-xl shadow hover:shadow-md transition-transform hover:scale-[1.02] flex items-center justify-between">
          <div>
            <p class="text-sm text-gray-500">Total Alumni</p>
            <h3 class="text-2xl font-bold">{{ $alumni }}</h3>
          </div>
          <span class="text-3xl text-indigo-500">👥</span>
        </div>

        <div class="bg-white border-l-4 border-green-500 p-6 rounded-xl shadow hover:shadow-md transition-transform hover:scale-[1.02] flex items-center justify-between">
          <div>
            <p class="text-sm text-gray-500">Pendaftaran</p>
            <h3 class="text-2xl font-bold">80</h3>
          </div>
          <span class="text-3xl text-green-500">🛒</span>
        </div>

        <div class="bg-white border-l-4 border-yellow-500 p-6 rounded-xl shadow hover:shadow-md transition-transform hover:scale-[1.02] flex items-center justify-between">
          <div>
            <p class="text-sm text-gray-500">Komentar</p>
            <h3 class="text-2xl font-bold">284</h3>
          </div>
          <span class="text-3xl text-yellow-500">💬</span>
        </div>

        <div class="bg-white border-l-4 border-pink-500 p-6 rounded-xl shadow hover:shadow-md transition-transform hover:scale-[1.02] flex items-center justify-between">
          <div>
            <p class="text-sm text-gray-500">Penghasilan</p>
            <h3 class="text-2xl font-bold">$7,842</h3>
          </div>
          <span class="text-3xl text-pink-500">💵</span>
        </div>
      </div>

      <!-- Charts -->
      @php
        $cardClass = "bg-white border border-gray-200 p-6 rounded-xl shadow hover:shadow-md transition-transform hover:scale-[1.02]";
        $titleClass = "text-lg font-semibold text-gray-800 mb-4 text-center border-b border-gray-200 pb-2";
        $buttonClass = "mt-4 bg-blue-600 hover:bg-blue-700 text-white py-2 px-6 rounded-lg shadow transition";
      @endphp

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div class="{{ $cardClass }}">
          <h3 class="{{ $titleClass }}">📊 Status Alumni</h3>
          <canvas id="pieChart" class="w-full h-64"></canvas>
          @if($statusAlumniLabels->isEmpty())
            <p class="text-center text-gray-500 mt-4 italic">Data alumni belum tersedia..</p>
          @endif
          <button id="downloadPieChart" class="{{ $buttonClass }}">Download Pie Chart</button>
        </div>

        <div class="{{ $cardClass }}">
          <h3 class="{{ $titleClass }}">📊 Jumlah Alumni per Status Pekerjaan</h3>
          <canvas id="barChart" class="w-full h-64"></canvas>
          <button id="downloadBarChart" class="{{ str_replace('bg-blue', 'bg-green', $buttonClass) }}">Download Bar Chart</button>
        </div>

        <div class="{{ $cardClass }}">
          <h3 class="{{ $titleClass }}">📈 Perkembangan Alumni per Angkatan</h3>
          <canvas id="lineChart" class="w-full h-64"></canvas>
          <button id="downloadLineChart" class="{{ str_replace('bg-blue', 'bg-yellow', $buttonClass) }}">Download Line Chart</button>
        </div>

        {{-- Radar Chart (Waktu Tunggu) - Belum tersedia --}}
        {{--
        <div class="{{ $cardClass }}">
          <h3 class="{{ $titleClass }}">⏳ Waktu Tunggu Alumni Bekerja</h3>
          <canvas id="radarChart" class="w-full h-64"></canvas>
          <button id="downloadRadarChart" class="{{ str_replace('bg-blue', 'bg-pink', $buttonClass) }}">Download Radar Chart</button>
        </div>
        --}}
      </div>

    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script>
    Chart.register(ChartDataLabels);

    document.addEventListener('DOMContentLoaded', () => {
      const textColor = '#374151';
      const gridColor = 'rgba(55,65,81,0.1)';
      const createChart = (ctx, type, data, options) => new Chart(ctx, { type, data, options });

      createChart(document.getElementById('pieChart'), 'pie', {
        labels: @json($statusAlumniLabels),
        datasets: [{
          data: @json($statusAlumniData),
          backgroundColor: ['#3B82F6', '#10B981', '#FBBF24', '#EC4899', '#8B5CF6'],
          borderColor: '#fff',
          borderWidth: 2
        }]
      }, {
        plugins: {
          legend: { labels: { color: textColor } },
          datalabels: {
            color: '#fff',
            font: { weight: 'bold', size: 14 },
            textStrokeColor: 'rgba(0,0,0,0.6)',
            textStrokeWidth: 2,
            formatter: (value, ctx) => {
              const sum = ctx.chart.data.datasets[0].data.reduce((a,b) => a+b, 0);
              return (value / sum * 100).toFixed(1) + '%';
            }
          }
        }
      });

      const totalAlumni = @json($statusAlumniData).reduce((a,b) => a + b, 0);

      createChart(document.getElementById('barChart'), 'bar', {
        labels: @json($statusAlumniLabels),
        datasets: [{
          label: 'Total Alumni: ' + totalAlumni,
          data: @json($statusAlumniData),
          backgroundColor: [
            'rgba(59, 130, 246, 0.8)',
            'rgba(16, 185, 129, 0.8)',
            'rgba(245, 158, 11, 0.8)',
            'rgba(236, 72, 153, 0.8)',
            'rgba(139, 92, 246, 0.8)'
          ],
          borderRadius: 6
        }]
      }, {
        scales: {
          x: { ticks: { color: textColor }, grid: { color: gridColor } },
          y: { beginAtZero: true, ticks: { color: textColor }, grid: { color: gridColor } }
        },
        plugins: {
          legend: { labels: { color: textColor } },
          datalabels: {
            color: '#fff',
            font: { weight: 'bold', size: 16 },
            textStrokeColor: 'rgba(0,0,0,0.6)',
            textStrokeWidth: 3
          }
        }
      });

      createChart(document.getElementById('lineChart'), 'line', {
        labels: @json($angkatanLabels),
        datasets: [{
          label: 'Jumlah Alumni per Angkatan',
          data: @json($angkatanData),
          borderColor: '#2563EB',
          backgroundColor: 'rgba(37, 99, 235, 0.2)',
          fill: true,
          tension: 0.4,
          pointBackgroundColor: '#2563EB',
          pointRadius: 5
        }]
      }, {
        scales: {
          x: { ticks: { color: textColor }, grid: { color: gridColor } },
          y: { beginAtZero: true, ticks: { color: textColor }, grid: { color: gridColor } }
        },
        plugins: {
          legend: { labels: { color: textColor } },
          datalabels: {
            color: '#2563EB',
            anchor: 'end',
            align: 'top',
            font: { weight: 'bold', size: 12 },
            formatter: (value) => value
          }
        }
      });

      // Radar chart - sementara dikomentari karena data belum tersedia
      /*
      createChart(document.getElementById('radarChart'), 'radar', {
        labels: 
        datasets: [{
          label: 'Jumlah Alumni',
          data: 
          borderColor: '#DB2777',
          backgroundColor: 'rgba(219, 39, 119, 0.3)', 
          fill: true
        }]
      }, {
        plugins: {
          legend: { labels: { color: textColor } },
          datalabels: {
            color: '#2563EB',
            font: { weight: 'bold', size: 12 },
            anchor: 'end',
            align: 'start',
            offset: 8,
            formatter: (value, ctx) => {
              const label = ctx.chart.data.labels[ctx.dataIndex];
              return `${label} = ${value} orang`;
            }
          }
        },
        scales: {
          r: {
            pointLabels: { color: textColor, font: { size: 15 } },
            ticks: {
              beginAtZero: true,
              stepSize: 1,
              precision: 0,
              color: textColor
            },
            grid: { color: 'rgba(0,0,0,0.1)' }
          }
        }
      });
      */

      const { jsPDF } = window.jspdf;
      const downloadChart = (btnId, canvasId, title, filename) => {
        document.getElementById(btnId).addEventListener('click', () => {
          const canvas = document.getElementById(canvasId);
          const pdf = new jsPDF();
          const today = new Date().toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });

          pdf.setFontSize(16);
          pdf.setFont('helvetica', 'bold');
          pdf.text(title, 10, 15);
          pdf.setFontSize(10);
          pdf.text(`Tanggal: ${today}`, 10, 22);
          pdf.line(10, 25, 200, 25);

          const image = canvas.toDataURL('image/png');
          pdf.addImage(image, 'PNG', 10, 30, 180, 130);
          pdf.setFontSize(8);
          pdf.setTextColor(150);
          pdf.text('Download dari Sistem Tracer Alumni', 10, 285);
          pdf.save(filename);
        });
      };

      downloadChart('downloadPieChart', 'pieChart', 'Status Alumni', 'pie_chart.pdf');
      downloadChart('downloadBarChart', 'barChart', 'Distribusi Alumni Berdasarkan Pekerjaan', 'bar_chart.pdf');
      downloadChart('downloadLineChart', 'lineChart', 'Jumlah Alumni per Angkatan', 'line_chart.pdf');

      // downloadChart('downloadRadarChart', 'radarChart', 'Waktu Tunggu Alumni Mendapatkan Pekerjaan', 'radar_chart.pdf');
    });
  </script>
</x-app-layout>
