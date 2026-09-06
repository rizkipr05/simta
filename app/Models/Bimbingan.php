<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bimbingan extends Model
{
    use HasFactory;

    protected $table = 'bimbingan';

    protected $fillable = [
        'skripsi_id',
        'dosen_id',
        'mahasiswa_id',
        'bab_bimbingan',
        'topik',
        'catatan_mahasiswa',
        'catatan_dosen',
        'file_dokumen',
        'status',
        'tanggal_bimbingan',
    ];

    protected $casts = [
        'tanggal_bimbingan' => 'datetime',
    ];

    public function skripsi(): BelongsTo
    {
        return $this->belongsTo(Skripsi::class);
    }

    public function dosen(): BelongsTo
    {
        return $this->belongsTo(Dosen::class);
    }

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}
