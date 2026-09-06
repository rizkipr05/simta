<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeritaAcara extends Model
{
    protected $table = 'berita_acara';

    protected $fillable = [
        'ujian_id', 'nomor_ba', 'nilai_akhir', 'predikat', 'keputusan',
        'rekomendasi', 'file_path', 'file_scan', 'status', 'approved_by', 'approved_at',
    ];

    protected $casts = ['approved_at' => 'datetime'];

    public function ujian()
    {
        return $this->belongsTo(Ujian::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
