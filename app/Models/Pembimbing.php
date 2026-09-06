<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembimbing extends Model
{
    protected $table = 'pembimbing';

    protected $fillable = ['skripsi_id', 'dosen_id', 'urutan', 'tanggal_disetujui', 'status'];

    protected $casts = ['tanggal_disetujui' => 'date'];

    public function skripsi()
    {
        return $this->belongsTo(Skripsi::class);
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    public function getPeranAttribute(): string
    {
        return $this->urutan == 1 ? 'Pembimbing I' : 'Pembimbing II';
    }
}
