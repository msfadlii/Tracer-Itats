# Arsitektur Sistem Tracer Alumni ITATS (Kelompok 5)

## I. Pendahuluan Arsitektur
Sistem Tracer Alumni ITATS Kelompok 5 dibangun menggunakan pendekatan **Containerized Micro-Architecture** berbasis Docker. Pendekatan ini dipilih untuk memecahkan masalah klasik "It works on my machine" dengan memastikan konsistensi antara lingkungan pengembangan lokal (laptop mahasiswa) dan lingkungan produksi (server).

Filosofi utama arsitektur kami adalah **Separation of Concerns** (Pemisahan Tanggung Jawab). Kami tidak menggabungkan web server, aplikasi, dan database dalam satu wadah raksasa, melainkan memecahnya menjadi layanan-layanan kecil yang saling berkomunikasi melalui jaringan internal Docker. Hal ini meningkatkan skalabilitas dan kemudahan pemeliharaan sistem.



## II. Alur Request (Request Lifecycle)
Setiap permintaan (request) yang masuk ke sistem Tracer Alumni melewati alur yang ketat untuk menjamin keamanan dan performa:

1.  **Entry Point (Nginx):** Nginx bertugas sebagai *Reverse Proxy* dan pintu gerbang utama. Saat pengguna mengakses `http://localhost`, Nginx menerima permintaan HTTP tersebut. Keuntungan menggunakan Nginx di depan aplikasi adalah kemampuannya yang sangat efisien dalam menyajikan file statis (gambar, CSS, JS) tanpa membebani prosesor PHP.
2.  **FastCGI Process (PHP-FPM):** Nginx tidak memproses kode PHP. Melalui konfigurasi `fastcgi_pass`, permintaan dinamis diteruskan ke container `app` yang menjalankan **PHP-FPM** pada port 9000. Komunikasi ini menggunakan protokol biner FastCGI yang jauh lebih cepat dibandingkan HTTP biasa.
3.  **Application Logic (Laravel):** Laravel memproses logika bisnis, termasuk validasi input, autentikasi, dan otorisasi.
4.  **Data Persistence:** Aplikasi kemudian berkomunikasi dengan database MySQL untuk menyimpan atau mengambil data alumni.

## III. Strategi Dual Database (Main & Analytics)
Untuk memenuhi **Kebutuhan Spesifik Kelompok 5**, kami menerapkan arsitektur *Dual Database Stack*. Ini adalah keputusan arsitektural untuk memisahkan beban kerja operasional dan analitik.

* **Database Utama (`db_main`):**
    * **Fungsi:** OLTP (*Online Transactional Processing*).
    * **Konten:** Menyimpan 1000 data alumni, data pengguna, dan jawaban kuesioner *real-time*.
    * **Prioritas:** Kecepatan penulisan (*Write Speed*) dan Integritas Data ACID.
* **Database Analitik (`db_analytics`):**
    * **Fungsi:** OLAP (*Online Analytical Processing*).
    * **Konten:** Menyimpan data agregat dan statistik hasil pengolahan.
    * **Prioritas:** Kecepatan pembacaan (*Read Speed*) untuk pelaporan kompleks.

Pemisahan ini sangat krusial dalam DevOps. Saat admin menjalankan query laporan berat di `db_analytics`, performa `db_main` tidak akan terganggu, sehingga alumni lain tetap bisa mengisi kuesioner dengan lancar tanpa *lag*.

## IV. Integrasi CI/CD dalam Arsitektur
Arsitektur kami tidak hanya mencakup infrastruktur *runtime*, tetapi juga infrastruktur pengembangan. Kami mengintegrasikan **GitHub Actions** sebagai orkestrator CI/CD yang terhubung langsung dengan repositori. Setiap perubahan pada kode akan melalui *Quality Gate* (PHPStan & PHPUnit) sebelum diizinkan untuk mengubah struktur arsitektur di lingkungan produksi.