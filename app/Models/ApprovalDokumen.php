<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApprovalDokumen extends Model
{
    protected $table = 'approval_dokumen';

    protected $fillable = ['dokumen_id', 'approved_by', 'status', 'catatan'];

    public function dokumen()
    {
        return $this->belongsTo(Dokumen::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
