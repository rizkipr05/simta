<?php

namespace Database\Seeders;

use App\Models\PersyaratanYudisium;
use Illuminate\Database\Seeder;

class PersyaratanYudisiumSeeder extends Seeder
{
    public function run(): void
    {
        $persyaratan = [
            ['nama_persyaratan' => 'Lembar Pengesahan Signed', 'deskripsi' => 'Scan lembar pengesahan skripsi yang sudah ditandatangani pembimbing dan dekan', 'wajib' => true, 'tipe_berkas' => 'pdf', 'urutan' => 1],
            ['nama_persyaratan' => 'Berita Acara Ujian', 'deskripsi' => 'Scan berita acara ujian skripsi yang sudah ditandatangani', 'wajib' => true, 'tipe_berkas' => 'pdf', 'urutan' => 2],
            ['nama_persyaratan' => 'Naskah Skripsi Final', 'deskripsi' => 'Naskah skripsi final dalam format PDF', 'wajib' => true, 'tipe_berkas' => 'pdf', 'urutan' => 3],
            ['nama_persyaratan' => 'Bebas Pustaka', 'deskripsi' => 'Surat keterangan bebas pustaka dari perpustakaan', 'wajib' => true, 'tipe_berkas' => 'pdf', 'urutan' => 4],
            ['nama_persyaratan' => 'Bebas Keuangan', 'deskripsi' => 'Surat keterangan bebas keuangan dari bagian keuangan', 'wajib' => true, 'tipe_berkas' => 'pdf', 'urutan' => 5],
            ['nama_persyaratan' => 'Pas Foto 4x6', 'deskripsi' => 'Pas foto terbaru background merah ukuran 4x6', 'wajib' => true, 'tipe_berkas' => 'image', 'urutan' => 6],
            ['nama_persyaratan' => 'KTM (Kartu Tanda Mahasiswa)', 'deskripsi' => 'Scan KTM yang masih berlaku', 'wajib' => true, 'tipe_berkas' => 'image', 'urutan' => 7],
            ['nama_persyaratan' => 'SK Yudisium Prodi', 'deskripsi' => 'SK penetapan dari program studi (opsional)', 'wajib' => false, 'tipe_berkas' => 'pdf', 'urutan' => 8],
        ];

        foreach ($persyaratan as $p) {
            PersyaratanYudisium::updateOrCreate(['nama_persyaratan' => $p['nama_persyaratan']], $p);
        }
    }
}
