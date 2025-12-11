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
        Schema::create('kas_mingguan', function (Blueprint $table) {
            $table->id();
            $table->integer('bulan'); // 1 - 12
            $table->integer('tahun'); // contoh: 2025
            $table->integer('minggu_ke'); // minggu ke berapa dalam bulan
            $table->date('tanggal_jumat'); // tanggal jumat pada minggu tsb
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kas_mingguan');
    }
};
