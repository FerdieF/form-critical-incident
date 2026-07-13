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
        Schema::create('critical_incidents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id')->constrained('karyawans')->onDelete('cascade');

            // Kolom ini buat ngebedain mana insiden Sukses, mana insiden Gagal
            $table->enum('jenis_insiden', ['Sukses', 'Gagal']);

            $table->string('topik')->nullable();
            $table->string('waktu_kejadian')->nullable();
            $table->text('kejadian')->nullable();
            $table->text('situasi')->nullable();
            $table->text('pelaku')->nullable();
            $table->text('pikiran_perasaan')->nullable();
            $table->text('perilaku')->nullable();
            $table->text('hasil')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('critical_incidents');
    }
};
