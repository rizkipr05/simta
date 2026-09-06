<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BerkasYudisium extends Model
{
    protected $table = 'berkas_yudisium';

    protected $fillable = ['pendaftaran_id', 'persyaratan_id', 'file_path', 'file_size', 'status', 'upload_by', 'verified_by', 'verified_at', 'catatan'];

    protected $casts = ['verified_at' => 'datetime'];

    public function pendaftaran()
    {
        return $this->belongsTo(PendaftaranYudisium::class);
    }

    public function persyaratan()
    {
        return $this->belongsTo(PersyaratanYudisium::class);
    }

    public function uploadBy()
    {
        return $this->belongsTo(User::class, 'upload_by');
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function getFileUrlAttribute(): string
    {
        return asset('storage/'.$this->file_path);
    }
}
