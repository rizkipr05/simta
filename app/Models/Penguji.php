<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penguji extends Model
{
    protected $table = 'penguji';

    protected $fillable = ['ujian_id', 'dosen_id', 'peran', 'catatan'];

    public function ujian()
    {
        return $this->belongsTo(Ujian::class);
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    public function nilai()
    {
        return $this->hasOne(NilaiUjian::class);
    }

    public function getPeranLabelAttribute(): string
    {
        return match ($this->peran) {
            'ketua' => 'Ketua Penguji',
            'penguji_1' => 'Penguji I',
            'penguji_2' => 'Penguji II',
            default => $this->peran,
        };
    }
}
