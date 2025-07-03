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
       Schema::create('jawaban_matrixs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengisian_id')->constrained('pengisians')->onDelete('cascade');
            $table->foreignId('pertanyaan_id')->constrained('pertanyaans')->onDelete('cascade');
            $table->foreignId('baris_matrix_id')->constrained('baris_matrixs')->onDelete('cascade');
            $table->string('jawaban');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_matrixs');
    }
};
