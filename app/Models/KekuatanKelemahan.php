<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
