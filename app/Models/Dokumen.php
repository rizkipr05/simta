<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    protected $table = 'dokumen';

    protected $fillable = ['skripsi_id', 'jenis', 'nama', 'file_path', 'file_size', 'status', 'uploaded_by', 'uploaded_at'];

    protected $casts = ['uploaded_at' => 'datetime'];

    public function skripsi()
    {
        return $this->belongsTo(Skripsi::class);
    }

    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function approval()
    {
        return $this->hasMany(ApprovalDokumen::class);
    }

    public function getFileUrlAttribute(): string
    {
        return asset('storage/'.$this->file_path);
    }
}
