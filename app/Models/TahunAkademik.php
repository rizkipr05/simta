<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunAkademik extends Model
{
    protected $table = 'tahun_akademik';

    protected $fillable = ['tahun', 'semester', 'tanggal_mulai', 'tanggal_selesai', 'is_aktif'];

    protected $casts = [
        'is_aktif' => 'boolean',
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function getLabelAttribute(): string
    {
        return $this->tahun.' '.$this->semester;
    }

    public function skripsi()
    {
        return $this->hasMany(Skripsi::class, 'tahun_akademik_id');
    }

    public static function aktif(): ?self
    {
        return static::where('is_aktif', true)->first();
    }
}
