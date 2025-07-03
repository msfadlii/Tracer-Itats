document.addEventListener('DOMContentLoaded', function () {
    const chartWrapper = document.getElementById('alumniChartWrapper');
    const labels = JSON.parse(chartWrapper.getAttribute('data-labels'));
    const data = JSON.parse(chartWrapper.getAttribute('data-data'));

    const ctx = document.getElementById('alumniChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',  // Jenis grafik, bisa diganti sesuai kebutuhan
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Pengisian Form Alumni',
                data: data,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    }); // <-- Pastikan ada penutupan kurung di sini untuk Chart.js

}); // <-- Pastikan ada penutupan kurung di sini untuk event listener
