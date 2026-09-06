<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ujian extends Model
{
    protected $table = 'ujian';

    protected $fillable = ['skripsi_id', 'jadwal', 'tempat', 'ruangan', 'status', 'catatan', 'dijadwalkan_oleh'];

    protected $casts = ['jadwal' => 'datetime'];

    public function skripsi()
    {
        return $this->belongsTo(Skripsi::class);
    }

    public function penguji()
    {
        return $this->hasMany(Penguji::class);
    }

    public function nilaiUjian()
    {
        return $this->hasMany(NilaiUjian::class);
    }

    public function beritaAcara()
    {
        return $this->hasOne(BeritaAcara::class);
    }

    public function skPenguji()
    {
        return $this->hasOne(SkPenguji::class);
    }

    public function dijadwalkanOleh()
    {
        return $this->belongsTo(User::class, 'dijadwalkan_oleh');
    }
}
