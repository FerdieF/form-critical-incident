<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KondisiKerja extends Model
{
    protected $fillable = [
        'karyawan_id',
        'penghasilan_sesuai',
        'penghasilan_penjelasan',
        'jaminan_belum_diberikan',
        'jaminan_penjelasan',
        'kondisi_kerja_saat_ini',
        'kondisi_kerja_penjelasan',
        'penilaian_prestasi',
        'aspek_optimalisasi',
    ];
}
