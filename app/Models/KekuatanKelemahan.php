<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KekuatanKelemahan extends Model
{
    use HasFactory;

    // Tambahkan izin mass-assignment ini:
    protected $fillable = [
        'karyawan_id',
        'kekuatan',
        'kelemahan',
    ];
}
