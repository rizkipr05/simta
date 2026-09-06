<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mahasiswa extends Model
{
    use SoftDeletes;

    protected $table = 'mahasiswa';

    protected $fillable = [
        'user_id', 'prodi_id', 'nim', 'nama', 'angkatan', 'semester',
        'no_hp', 'email', 'foto', 'status_skripsi',
    ];

    // State machine statuses
    const STATUS_BELUM_DAFTAR = 'belum_daftar';

    const STATUS_PENGAJUAN = 'pengajuan';

    const STATUS_PEMBIMBING_DITETAPKAN = 'pembimbing_ditetapkan';

    const STATUS_SK_PEMBIMBING_DISAHKAN = 'sk_pembimbing_disahkan';

    const STATUS_BIMBINGAN = 'bimbingan';

    const STATUS_SIAP_UJIAN = 'siap_ujian';

    const STATUS_UJIAN_DIJADWALKAN = 'ujian_dijadwalkan';

    const STATUS_UJIAN_SELESAI = 'ujian_selesai';

    const STATUS_NILAI_FINAL = 'nilai_final';

    const STATUS_BA_FINAL = 'ba_final';

    const STATUS_MENUNGGU_PENGESAHAN = 'menunggu_pengesahan';

    const STATUS_PENGESAHAN_DIUPLOAD = 'pengesahan_diupload';

    const STATUS_PENGESAHAN_TERVERIFIKASI = 'pengesahan_terverifikasi';

    const STATUS_ADMINISTRASI_SELESAI = 'administrasi_selesai';

    const STATUS_ELIGIBLE_YUDISIUM = 'eligible_yudisium';

    const STATUS_MENDAFTAR_YUDISIUM = 'mendaftar_yudisium';

    const STATUS_SELESAI = 'selesai';

    public static function statusLabels(): array
    {
        return [
            self::STATUS_BELUM_DAFTAR => 'Belum Daftar',
            self::STATUS_PENGAJUAN => 'Pengajuan',
            self::STATUS_PEMBIMBING_DITETAPKAN => 'Pembimbing Ditetapkan',
            self::STATUS_SK_PEMBIMBING_DISAHKAN => 'SK Pembimbing Disahkan',
            self::STATUS_BIMBINGAN => 'Bimbingan',
            self::STATUS_SIAP_UJIAN => 'Siap Ujian',
            self::STATUS_UJIAN_DIJADWALKAN => 'Ujian Dijadwalkan',
            self::STATUS_UJIAN_SELESAI => 'Ujian Selesai',
            self::STATUS_NILAI_FINAL => 'Nilai Final',
            self::STATUS_BA_FINAL => 'BA Final',
            self::STATUS_MENUNGGU_PENGESAHAN => 'Menunggu Pengesahan',
            self::STATUS_PENGESAHAN_DIUPLOAD => 'Pengesahan Diupload',
            self::STATUS_PENGESAHAN_TERVERIFIKASI => 'Pengesahan Terverifikasi',
            self::STATUS_ADMINISTRASI_SELESAI => 'Administrasi Selesai',
            self::STATUS_ELIGIBLE_YUDISIUM => 'Eligible Yudisium',
            self::STATUS_MENDAFTAR_YUDISIUM => 'Mendaftar Yudisium',
            self::STATUS_SELESAI => 'Selesai',
        ];
    }

    public function getStatusLabelAttribute(): string
    {
        return self::statusLabels()[$this->status_skripsi] ?? ucwords(str_replace('_', ' ', $this->status_skripsi));
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

    public function skripsi()
    {
        return $this->hasOne(Skripsi::class);
    }

    public function pendaftaranYudisium()
    {
        return $this->hasMany(PendaftaranYudisium::class);
    }
}
