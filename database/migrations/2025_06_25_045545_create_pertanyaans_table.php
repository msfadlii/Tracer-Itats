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
       Schema::create('pertanyaans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('halaman_kuesioner_id')->constrained('halaman_kuesioners')->onDelete('cascade');
            $table->text('teks');
            $table->foreignId('jenis_pertanyaan_id')->constrained('jenis_pertanyaans')->onDelete('cascade');
            $table->boolean('wajib')->default(false);
            $table->boolean('punya_opsi_lain')->default(false);
            $table->integer('urutan');
            $table->json('atribut_ekstra')->nullable();
            $table->boolean('visualisasi')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertanyaans');
    }
};
