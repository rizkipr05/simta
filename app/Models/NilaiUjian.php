<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiUjian extends Model
{
    protected $table = 'nilai_ujian';

    protected $fillable = [
        'ujian_id', 'penguji_id', 'nilai_penguasaan_materi',
        'nilai_kemampuan_presentasi', 'nilai_penulisan', 'nilai_total', 'catatan',
    ];

    protected $casts = [
        'nilai_penguasaan_materi' => 'decimal:2',
        'nilai_kemampuan_presentasi' => 'decimal:2',
        'nilai_penulisan' => 'decimal:2',
        'nilai_total' => 'decimal:2',
    ];

    public function ujian()
    {
        return $this->belongsTo(Ujian::class);
    }

    public function penguji()
    {
        return $this->belongsTo(Penguji::class);
    }

    public function getGradeAttribute(): string
    {
        $nilai = (float) $this->nilai_total;
        if ($nilai >= 90) {
            return 'A';
        }
        if ($nilai >= 80) {
            return 'AB';
        }
        if ($nilai >= 70) {
            return 'B';
        }
        if ($nilai >= 60) {
            return 'BC';
        }
        if ($nilai >= 50) {
            return 'C';
        }
        if ($nilai >= 40) {
            return 'D';
        }

        return 'E';
    }
}
