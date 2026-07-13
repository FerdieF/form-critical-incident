<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bawahan extends Model
{
    use HasFactory;

    // Kolom-kolom yang diizinkan untuk diisi secara massal (mass assignment)
    protected $fillable = [
        'karyawan_id',
        'nama',
        'bagian',
        'peran',
    ];

    // Relasi balik ke tabel Karyawan (Opsional tapi sangat disarankan)
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
