<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CriticalIncident extends Model
{
    use HasFactory;

    protected $fillable = [
        'karyawan_id',
        'jenis_insiden',
        'topik',
        'waktu_kejadian',
        'kejadian', // <-- Pastikan ini ada
        'situasi',  // <-- Dan ini
        'pelaku',
        'pikiran_perasaan',
        'perilaku',
        'hasil',
    ];
}
