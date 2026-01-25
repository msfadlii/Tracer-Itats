# Strategi Monitoring dan Alerting Sistem Tracer Alumni

## I. Metrik Kesehatan Aplikasi (Health Monitoring)
Pemantauan kesehatan aplikasi dilakukan secara berkelanjutan (continuous monitoring) untuk memastikan ketersediaan layanan 24/7 bagi alumni ITATS. Dalam arsitektur Docker Compose kami, strategi pemantauan diterapkan pada level container:

* **Liveness Probe:** Kami mengonfigurasi `healthcheck` pada setiap layanan di `docker-compose.yml`. Misalnya, container MySQL diperiksa setiap 10 detik menggunakan perintah `mysqladmin ping`. Jika gagal merespon sebanyak 3 kali, container ditandai *unhealthy* dan sistem orkestrasi dapat melakukan *restart* otomatis.
* **Dependency Check:** Container aplikasi (`tc_app`) dikonfigurasi untuk tidak memulai proses Laravel sebelum container database melaporkan status "Healthy". Ini mencegah error koneksi (*Connection Refused*) saat *startup* awal.

## II. Mekanisme Alerting (Build & Test Failures)
Dalam siklus DevOps, kegagalan adalah informasi yang berharga. Kami mengonfigurasi sistem notifikasi pada pipeline CI/CD GitHub Actions:

1.  **Build Failure Alert:** Jika terjadi kegagalan saat instalasi dependensi atau kompilasi aset, notifikasi segera dikirim ke email pengembang.
2.  **Quality Gate Breach:** Jika *Static Code Analysis* (Larastan) menemukan kode yang tidak sesuai standar, atau jika *Unit Test* gagal memvalidasi dataset 1000 alumni, pipeline akan berhenti total (*Hard Stop*). Ini berfungsi sebagai *Alert* kritis bahwa kode tersebut tidak layak rilis.

## III. Monitoring Kualitas Kode (SCA & Dependency)
Selain memantau server, kami juga memantau kesehatan kode sumber:
* **Vulnerability Monitoring:** Menggunakan `composer audit` untuk memantau apakah library pihak ketiga (seperti `symfony/http-foundation`) memiliki celah keamanan CVE terbaru.
* **Deprecation Monitoring:** Memantau paket yang sudah ditinggalkan (*abandoned*), seperti kasus migrasi dari `nunomaduro/larastan` ke `larastan/larastan` yang kami lakukan untuk menjaga keberlanjutan proyek.

## IV. Log Aggregation dan Analisis Performa
Seluruh log dari container aplikasi (Laravel logs) dan web server (Nginx access/error logs) dikumpulkan secara terpusat melalui `docker logs`. Kami berfokus pada pelacakan anomali spesifik:
* **Memory Usage Spikes:** Memantau lonjakan RAM saat proses *Seeding* 1000 data alumni.
* **Response Time:** Memastikan respons API untuk data analitik tetap di bawah 200ms meskipun mengakses tabel berukuran besar.