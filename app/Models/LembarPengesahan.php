<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LembarPengesahan extends Model
{
    protected $table = 'lembar_pengesahan';

    protected $fillable = ['skripsi_id', 'file_draft', 'file_scan', 'status', 'verified_by', 'verified_at', 'catatan'];

    protected $casts = ['verified_at' => 'datetime'];

    public function skripsi()
    {
        return $this->belongsTo(Skripsi::class);
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
