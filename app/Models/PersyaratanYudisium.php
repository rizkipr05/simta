<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersyaratanYudisium extends Model
{
    protected $table = 'persyaratan_yudisium';

    protected $fillable = ['nama_persyaratan', 'deskripsi', 'wajib', 'tipe_berkas', 'urutan'];

    protected $casts = ['wajib' => 'boolean'];

    public function berkas()
    {
        return $this->hasMany(BerkasYudisium::class, 'persyaratan_id');
    }
}
