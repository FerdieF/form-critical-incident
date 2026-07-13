<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory; // Tambahkan ini biar fitur Factory aktif (standar Laravel)

    // Pastikan nama tabelnya sesuai
    protected $table = 'karyawans';

    // Buka gembok biar semua kolom bisa diisi dari form
    protected $guarded = ['id'];

    // ------------------------------------------------------
    // RELASI KE AKUN USER (One-to-One)
    // ------------------------------------------------------
    public function user()
    {
        // Data Karyawan ini milik User tertentu, dihubungkan lewat kolom 'nik_sap'
        return $this->belongsTo(User::class, 'nik_sap', 'nik_sap');
    }

    // ------------------------------------------------------
    // RELASI KE TABEL DETAIL (One-to-Many)
    // ------------------------------------------------------
    public function keluargas()
    {
        return $this->hasMany(Keluarga::class, 'karyawan_id');
    }

    public function pendidikans()
    {
        return $this->hasMany(Pendidikan::class, 'karyawan_id');
    }

    public function pengalamanKerjas()
    {
        return $this->hasMany(PengalamanKerja::class, 'karyawan_id');
    }

    public function bawahans()
    {
        return $this->hasMany(Bawahan::class, 'karyawan_id');
    }

    public function criticalIncidents()
    {
        return $this->hasMany(CriticalIncident::class, 'karyawan_id');
    }

    // ------------------------------------------------------
    // RELASI KE TABEL FORM (One-to-One)
    // ------------------------------------------------------
    public function detailPekerjaan()
    {
        return $this->hasOne(DetailPekerjaan::class, 'karyawan_id');
    }

    public function kondisiKerja()
    {
        return $this->hasOne(KondisiKerja::class, 'karyawan_id');
    }

    public function minatHarapan()
    {
        return $this->hasOne(MinatHarapan::class, 'karyawan_id');
    }

    public function usahaAspirasi()
    {
        return $this->hasOne(UsahaAspirasi::class, 'karyawan_id');
    }

    public function kekuatanKelemahan()
    {
        return $this->hasOne(KekuatanKelemahan::class, 'karyawan_id');
    }
}
