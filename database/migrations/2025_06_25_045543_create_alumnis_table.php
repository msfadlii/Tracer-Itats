<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('alumnis', function (Blueprint $table) {
            $table->id();
            $table->year('tahun_lulus');
            $table->string('npm')->unique();
            $table->string('nama');
            $table->string('nik', 20)->unique();
            $table->date('tanggal_lahir');
            $table->string('email')->unique();
            $table->string('telepon')->nullable();
            $table->string('npwp')->nullable();
            $table->string('dosen_pembimbing');
            $table->string('pembiayaan')->nullable();
            $table->enum('status', [
                'Bekerja (full time/part time)',
                'Belum Memungkinkan Bekerja',
                'Wiraswasta',
                'Melanjutkan Pendidikan',
                'Tidak Kerja Tetapi Sedang Mencari Kerja'
            ])->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnis');
    }
};
