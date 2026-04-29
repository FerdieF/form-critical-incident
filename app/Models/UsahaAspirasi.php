<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsahaAspirasi extends Model
{
    use HasFactory;

    // Tambahkan baris ini untuk mengizinkan penyimpanan data:
    protected $fillable = [
        'karyawan_id',
        'bidang_diminati',
        // WAJIB DITAMBAHKAN: Jika di form tabel usaha kamu ada kolom lain 
        // (misalnya 'alasan', 'upaya', dll), masukkan juga nama-nama kolomnya di bawah ini!
    ];

    // ... relasi ke Karyawan jika ada ...
}