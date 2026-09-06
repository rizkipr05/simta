<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dosen extends Model
{
    use SoftDeletes;

    protected $table = 'dosen';

    protected $fillable = [
        'user_id', 'prodi_id', 'nidn', 'nama', 'gelar_depan', 'gelar_belakang',
        'jabatan', 'status_kepegawaian', 'email', 'no_hp', 'foto', 'is_aktif',
    ];

    protected $casts = ['is_aktif' => 'boolean'];

    public function getNamaLengkapAttribute(): string
    {
        $gelar_depan = $this->gelar_depan ? $this->gelar_depan.' ' : '';
        $gelar_belakang = $this->gelar_belakang ? ', '.$this->gelar_belakang : '';

        return $gelar_depan.$this->nama.$gelar_belakang;
    }

    public function getFotoUrlAttribute(): string
    {
        if ($this->foto) {
            return asset('storage/'.$this->foto);
        }
        $name = urlencode($this->nama);

        return "https://ui-avatars.com/api/?name={$name}&background=1e3a5f&color=fff&size=128";
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function prodi()
    {
        return $this->belongsTo(ProgramStudi::class, 'prodi_id');
    }

    public function pembimbingan()
    {
        return $this->hasMany(Pembimbing::class);
    }

    public function pengujian()
    {
        return $this->hasMany(Penguji::class);
    }

    public function nilaiUjian()
    {
        return $this->hasManyThrough(NilaiUjian::class, Penguji::class);
    }
}
