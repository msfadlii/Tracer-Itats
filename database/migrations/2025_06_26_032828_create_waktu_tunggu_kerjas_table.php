<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
       public function up()
        {
            Schema::create('waktu_tunggu_kerjas', function (Blueprint $table) {
                $table->id();
                $table->foreignId('alumni_id')->constrained()->onDelete('cascade');
                $table->string('waktu_tunggu_bulan')->nullable();
                $table->timestamps();
            });
        }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waktu_tunggu_kerja');
    }
};
