<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Skripsi extends Model
{
    protected $table = 'skripsi';

    use SoftDeletes;

    protected $fillable = [
        'mahasiswa_id', 'tahun_akademik_id', 'judul', 'deskripsi', 'bidang_kajian',
        'tanggal_pengajuan', 'tanggal_mulai', 'status', 'catatan_penolakan',
        'reviewed_by', 'reviewed_at',
    ];

    protected $casts = [
        'tanggal_pengajuan' => 'date',
        'tanggal_mulai' => 'date',
        'reviewed_at' => 'datetime',
    ];

    public static function statusLabels(): array
    {
        return [
            'pengajuan' => 'Pengajuan',
            'diterima' => 'Diterima',
            'ditolak' => 'Ditolak',
            'aktif' => 'Aktif',
            'selesai' => 'Selesai',
        ];
    }

    // Relationships
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function tahunAkademik()
    {
        return $this->belongsTo(TahunAkademik::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function pembimbing()
    {
        return $this->hasMany(Pembimbing::class);
    }

    public function skPembimbing()
    {
        return $this->hasOne(SkPembimbing::class);
    }

    public function ujian()
    {
        return $this->hasOne(Ujian::class);
    }

    public function beritaAcara()
    {
        return $this->hasOneThrough(BeritaAcara::class, Ujian::class, 'skripsi_id', 'ujian_id', 'id', 'id');
    }

    public function bimbingan()
    {
        return $this->hasMany(Bimbingan::class);
    }

    public function dokumen()
    {
        return $this->hasMany(Dokumen::class);
    }

    public function lembarPengesahan()
    {
        return $this->hasOne(LembarPengesahan::class);
    }

    public function pembimbing1()
    {
        return $this->hasOne(Pembimbing::class)->where('urutan', 1)->with('dosen');
    }

    public function pembimbing2()
    {
        return $this->hasOne(Pembimbing::class)->where('urutan', 2)->with('dosen');
    }
}
