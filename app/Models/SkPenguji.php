<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkPenguji extends Model
{
    protected $table = 'sk_penguji';

    protected $fillable = ['ujian_id', 'nomor_sk', 'tanggal_sk', 'file_path', 'status', 'approved_by', 'approved_at', 'catatan'];

    protected $casts = ['tanggal_sk' => 'date', 'approved_at' => 'datetime'];

    public function ujian()
    {
        return $this->belongsTo(Ujian::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
