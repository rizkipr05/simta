<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkPembimbing extends Model
{
    protected $table = 'sk_pembimbing';

    protected $fillable = ['skripsi_id', 'nomor_sk', 'tanggal_sk', 'file_path', 'file_scan', 'status', 'approved_by', 'approved_at', 'catatan'];

    protected $casts = ['tanggal_sk' => 'date', 'approved_at' => 'datetime'];

    public function skripsi()
    {
        return $this->belongsTo(Skripsi::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
