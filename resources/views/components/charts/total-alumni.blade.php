document.addEventListener('DOMContentLoaded', function () {
    const chartWrapper = document.getElementById('alumniChartWrapper');
    const labels = JSON.parse(chartWrapper.getAttribute('data-labels'));
    const data = JSON.parse(chartWrapper.getAttribute('data-data'));

    console.log(labels);  // Cek apakah labels diteruskan dengan benar
    console.log(data);    // Cek apakah data diteruskan dengan benar

    const ctx = document.getElementById('alumniChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',  // Jeis grafik, bisa diganti sesuai kebutuhan
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
    });
});
