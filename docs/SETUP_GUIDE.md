# Panduan Instalasi dan Setup Teknis (Setup Guide)

## I. Prasyarat Sistem (System Requirements)
Sebelum menjalankan aplikasi Tracer Alumni ITATS, pastikan lingkungan host Anda memenuhi spesifikasi berikut untuk menghindari kegagalan build:

1.  **Docker Desktop:** Versi terbaru dengan backend WSL 2 aktif.
2.  **Konfigurasi Sumber Daya WSL 2:**
    * File `.wslconfig` wajib dikonfigurasi.
    * **RAM:** Alokasikan minimal **4GB**. Proses kompilasi ekstensi PHP `intl` dan `gd` pada image Alpine Linux sangat intensif memori. Jika RAM kurang, proses `docker-compose build` akan gagal dengan *Exit Code 1*.
3.  **Git:** Untuk kloning repositori.

## II. Langkah Instalasi (Local Environment)

### Langkah 1: Persiapan Repositori
Kloning repositori dan masuk ke direktori proyek:

git clone [https://github.com/msfadliii/Tracer-Itats.git](https://github.com/msfadliii/Tracer-Itats.git)
cd Tracer-Itats 

### Langkah 2: Menjalankan Docker Compose
Jalankan perintah berikut untuk membangun image dan menjalankan container di latar belakang:

docker-compose -f docker/docker-compose.yml up -d --build

Flag `-f docker/docker-compose.yml` menginstruksikan Docker untuk membaca konfigurasi dari sub-folder tersebut, sementara context build telah dikonfigurasi untuk tetap mengarah ke root project agar seluruh kode sumber Laravel dapat terbaca.
Catatan: Proses ini memakan waktu 5-10 menit di awal karena Docker harus mengunduh base image PHP-Alpine dan mengompilasi ekstensi yang dibutuhkan.

### Langkah 3: Inisialisasi Aplikasi Laravel
Setelah container berstatus running, lakukan inisialisasi internal:

# Masuk ke shell container
docker exec -it tc_app sh

# Instal dependensi PHP
composer install

# Generate Application Key
php artisan key:generate

# Migrasi Database & Seeding 1000 Data
php artisan migrate:fresh --seed --class=AlumniSeeder

## III. Verifikasi Instalasi
Buka browser dan akses http://localhost.
- Verifikasi Data: Pastikan Anda melihat daftar data alumni. Cek database untuk memastikan jumlah baris mencapai 1000 record.
- Verifikasi API: Akses endpoint /analytics/summary (jika sudah diimplementasikan) untuk memastikan integritas data analitik.

## IV. Manajemen Dependensi dan Keamanan
Jika Anda perlu menambahkan library baru, jangan lakukan dari host Windows secara langsung jika tidak memiliki PHP lokal. Gunakan container:

docker exec -it tc_app composer require nama/paket

Selalu jalankan composer audit secara berkala untuk memastikan tidak ada kerentanan keamanan baru yang terdeteksi pada dependensi proyek.


