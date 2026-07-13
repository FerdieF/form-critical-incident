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
        Schema::create('kondisi_kerjas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id')->constrained('karyawans')->onDelete('cascade');

            // Pertanyaan 1
            $table->string('penghasilan_sesuai')->nullable();
            $table->text('penghasilan_penjelasan')->nullable();

            // Pertanyaan 2
            $table->string('jaminan_belum_diberikan')->nullable();
            $table->text('jaminan_penjelasan')->nullable();

            // Pertanyaan 3
            $table->string('kondisi_kerja_saat_ini')->nullable();
            $table->text('kondisi_kerja_penjelasan')->nullable();

            // Pertanyaan 4
            $table->string('penilaian_prestasi')->nullable();

            // Pertanyaan 5
            $table->text('aspek_optimalisasi')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kondisi_kerjas');
    }
};
