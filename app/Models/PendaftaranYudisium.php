<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendaftaranYudisium extends Model
{
    protected $table = 'pendaftaran_yudisium';

    protected $fillable = ['mahasiswa_id', 'periode_id', 'tanggal_daftar', 'status', 'catatan', 'verified_by', 'verified_at'];

    protected $casts = ['tanggal_daftar' => 'date', 'verified_at' => 'datetime'];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function periode()
    {
        return $this->belongsTo(PeriodeYudisium::class);
    }

    public function berkas()
    {
        return $this->hasMany(BerkasYudisium::class, 'pendaftaran_id');
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
