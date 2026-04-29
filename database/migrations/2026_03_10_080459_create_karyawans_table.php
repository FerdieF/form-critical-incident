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
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            
            // PASTIKAN BARIS INI ADA DAN NAMANYA TEPAT 'nik_sap'
            $table->string('nik_sap')->unique(); 
            
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('jenis_kelamin');
            $table->string('agama')->nullable();
            $table->string('status_pernikahan')->nullable();
            $table->text('alamat');
            $table->string('perusahaan')->nullable();
            $table->string('golongan')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('alamat_perusahaan')->nullable();
            $table->string('nama_atasan_langsung')->nullable();
            $table->string('jabatan_atasan_langsung')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};
