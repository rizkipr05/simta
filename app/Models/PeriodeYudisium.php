<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeriodeYudisium extends Model
{
    protected $table = 'periode_yudisium';

    protected $fillable = ['nama_periode', 'tahun', 'angkatan', 'tanggal_buka_pendaftaran', 'tanggal_tutup_pendaftaran', 'tanggal_yudisium', 'tempat', 'is_aktif', 'status'];

    protected $casts = [
        'is_aktif' => 'boolean',
        'tanggal_buka_pendaftaran' => 'date',
        'tanggal_tutup_pendaftaran' => 'date',
        'tanggal_yudisium' => 'date',
    ];

    public function pendaftaran()
    {
        return $this->hasMany(PendaftaranYudisium::class, 'periode_id');
    }
}
