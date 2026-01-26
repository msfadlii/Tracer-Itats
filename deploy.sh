#!/bin/bash

echo "🚀 MEMULAI DEPLOYMENT OTOMATIS KELOMPOK 5..."

# 1. Matikan container lama
echo "⬇️  Mematikan container lama..."
docker-compose -f docker/docker-compose.yml down

# 2. Tarik image terbaru dari Docker Hub (Hasil GitHub Actions)
echo "📥 Menarik image terbaru..."
docker-compose -f docker/docker-compose.yml pull

# 3. Nyalakan container (Background)
echo "🔥 Menyalakan aplikasi..."
docker-compose -f docker/docker-compose.yml up -d

# 4. Tunggu sebentar agar Database siap (PENTING)
echo "⏳ Menunggu database booting (10 detik)..."
sleep 10

# 5. Jalankan Migrasi & Seeding Otomatis (DUAL DB)
echo "📦 Menjalankan Migrasi Database UTAMA..."
docker exec tc_app php artisan migrate:fresh --seed --class=AlumniSeeder --force

echo "📊 Menjalankan Migrasi Database ANALITIK..."
docker exec tc_app php artisan migrate:fresh --database=mysql_analytics --path=database/migrations --seed --class=AlumniSeeder --force

# 6. Generate Key (Hanya jika belum ada di .env container)
# Opsional: Biasanya key sudah ada di .env host
echo "🔑 Memastikan Application Key..."
docker exec tc_app php artisan key:generate

echo "✅ DEPLOYMENT SELESAI! Silakan akses http://localhost"