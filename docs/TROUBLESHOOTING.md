Deskripsi: Solusi masalah teknis yang sering ditemui.

Masalah 1: Error 502 Bad Gateway
Penyebab: Kesalahan ini muncul ketika Nginx tidak dapat menemukan layanan PHP-FPM atau ketika proses PHP-FPM berhenti mendadak. Solusi:
- Pastikan container app sedang berjalan dengan perintah docker ps.
- Periksa apakah port 9000 di container app terbuka.
- Seringkali masalah ini disebabkan oleh "Volume Masking", di mana folder vendor di laptop menimpa folder vendor di container. Solusinya adalah menambahkan - /var/www/html/vendor pada bagian volumes di docker-compose.yaml.

Masalah 2: SQLSTATE[HY000] [1045] Access Denied
Penyebab: Laravel mencoba mengakses database menggunakan kredensial yang salah atau menggunakan host 127.0.0.1 di dalam jaringan Docker. Solusi:
- Di dalam Docker, DB_HOST tidak boleh berisi 127.0.0.1 melainkan harus berisi nama service database, yaitu db_main.
- Pastikan password di file .env sama dengan MYSQL_ROOT_PASSWORD di docker-compose.yaml. Jika Anda mengubah password di .env, Anda harus menghapus volume database lama dengan docker-compose down -v agar perubahan diterapkan pada database baru.

Masalah 3: Build Error (Exit Code 1) pada apk add
Penyebab: Proses instalasi atau kompilasi ekstensi PHP terhenti karena kehabisan RAM atau koneksi internet yang tidak stabil saat mengunduh package dari repositori Alpine. Solusi:
- Naikkan RAM WSL 2 melalui .wslconfig.
- Gunakan flag -j$(nproc) pada perintah docker-php-ext-install di Dockerfile agar proses kompilasi menggunakan semua core CPU yang tersedia, yang dapat membantu stabilitas proses build.


Masalah: Pipeline gagal pada tahap Run composer audit dengan pesan error keamanan.
Solusi: Melakukan composer update pada paket terkait dan memastikan composer.lock diperbarui di repositori untuk melewati pemeriksaan keamanan pada build berikutnya.