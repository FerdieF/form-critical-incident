<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPekerjaan extends Model
{
    use HasFactory;

    // Tambahkan array fillable ini:
    protected $fillable = [
        'karyawan_id',
        'tugas_dua_posisi_terakhir',
        'struktur_organisasi',
        'tanggung_jawab',
        'uraian_tanggung_jawab',
    ];

    // ... relasi ke Karyawan jika ada ...
}
