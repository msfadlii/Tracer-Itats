Deskripsi: Panduan teknis instalasi sistem.

Prasyarat Sistem
Sebelum menjalankan aplikasi Tracer Alumni ini, pastikan sistem Anda telah memenuhi spesifikasi berikut:
- Docker Desktop: Versi terbaru dengan WSL 2 Backend.
- RAM: Minimal 4GB (karena proses build Alpine Linux memerlukan kompilasi intensif).
- WSL 2 Configuration: Karena build PHP-FPM Alpine mengompilasi ekstensi intl dan gd, Anda wajib menaikkan limit RAM WSL.

Langkah 1: Menjalankan Docker Compose
Buka terminal di folder proyek, kemudian jalankan perintah pembangunan image:

docker-compose up -d --build

Proses ini akan memakan waktu sekitar 5-10 menit untuk pertama kali karena sistem melakukan kompilasi library intl, gd, dan zip agar aplikasi mendukung fitur ekspor/impor data 1000 alumni.

Langkah 3: Inisialisasi Laravel
Setelah container berstatus running, Anda harus melakukan setup internal Laravel di dalam container app:
- Masuk ke container: docker exec -it tc_app sh
- Generate key: php artisan key:generate
- Jalankan Migrasi & Seeder 1000 data: php artisan migrate:fresh --seed --class=AlumniSeeder

Akses Aplikasi
Setelah semua langkah selesai, aplikasi dapat diakses melalui browser pada alamat http://localhost. Pastikan Anda melihat daftar 1000 data alumni untuk memverifikasi bahwa Large Dataset telah berhasil dimuat ke dalam db_main.


