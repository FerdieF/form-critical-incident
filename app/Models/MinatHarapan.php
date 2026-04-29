<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MinatHarapan extends Model
{
    protected $fillable = [
        'karyawan_id',
        'hal_disukai',
        'hal_tidak_disukai',
        'alasan_memilih_karier',
        'aspirasi_lima_tahun'
    ];
}
