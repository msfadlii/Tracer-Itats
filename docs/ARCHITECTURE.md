Deskripsi: Penjelasan alur request dan pemisahan database.

Pendahuluan Arsitektur
Sistem Tracer Alumni ITATS Kelompok 5 dibangun menggunakan arsitektur containerized yang berbasis pada Docker. Pendekatan ini dipilih untuk memastikan konsistensi lingkungan pengembangan (laptop mahasiswa) dengan lingkungan produksi (server). Inti dari arsitektur ini adalah pemisahan tanggung jawab antara setiap komponen layanan atau yang sering disebut dengan Separation of Concerns.

Alur Request (Nginx ke App)
Dalam sistem ini, Nginx bertugas sebagai Reverse Proxy dan pintu gerbang utama. Ketika pengguna mengakses http://localhost, Nginx menerima permintaan tersebut. Namun, Nginx tidak memproses kode PHP secara langsung. Melalui konfigurasi fastcgi_pass, Nginx meneruskan permintaan ke container app yang menjalankan PHP-FPM pada port 9000. Komunikasi ini menggunakan protokol FastCGI yang jauh lebih cepat dan efisien dibandingkan HTTP biasa untuk komunikasi antar container. Keuntungan menggunakan Nginx di depan aplikasi adalah kemampuannya dalam menangani file statis (seperti gambar, CSS, dan JS) tanpa membebani prosesor PHP, sehingga aplikasi tetap responsif meskipun menangani Large Dataset.

Strategi Dual Database (Main & Analytics)
Sesuai dengan syarat khusus Kelompok 5, sistem ini menggunakan dua instance database MySQL yang terpisah.

Database Utama (db_main): Digunakan untuk operasi harian (OLTP - Online Transactional Processing). Di sinilah 1000 data alumni, data user, dan master kuesioner disimpan. Fokus utama database ini adalah integritas data dan kecepatan penulisan.

Database Analitik (db_analytics): Digunakan untuk pemrosesan data statistik (OLAP - Online Analytical Processing). Data dari hasil kuesioner yang masif akan diolah di sini untuk menghasilkan grafik dan laporan tanpa mengganggu performa database utama. Pemisahan ini sangat krusial dalam DevOps untuk menjaga stabilitas sistem saat admin sedang menjalankan query laporan yang berat sementara alumni lain sedang mengisi kuesioner secara bersamaan.

Keuntungan Infrastruktur Container
Dengan menggunakan Docker Compose, seluruh stack teknologi ini dapat dijalankan dengan satu perintah. Penggunaan volume pada Docker memastikan bahwa data alumni yang berjumlah 1000 tetap aman meskipun container dimatikan. Selain itu, penggunaan anonymous volume pada folder /vendor memastikan library aplikasi tidak rusak akibat konflik antara sistem operasi Windows (host) dan Linux (container).