<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramStudi extends Model
{
    use SoftDeletes;

    protected $table = 'program_studi';

    protected $fillable = ['kode', 'nama', 'jenjang', 'ketua', 'status'];

    protected $casts = ['status' => 'boolean'];

    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class, 'prodi_id');
    }

    public function dosen()
    {
        return $this->hasMany(Dosen::class, 'prodi_id');
    }
}
