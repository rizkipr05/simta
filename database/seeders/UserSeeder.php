<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Pembimbing;
use App\Models\ProgramStudi;
use App\Models\SkPembimbing;
use App\Models\Skripsi;
use App\Models\TahunAkademik;
use App\Models\Bimbingan;
use App\Models\User;
use App\Models\Dokumen;
use App\Models\Ujian;
use App\Models\Penguji;
use App\Models\NilaiUjian;
use App\Models\BeritaAcara;
use App\Models\SkPenguji;
use App\Models\LembarPengesahan;
use App\Models\PendaftaranYudisium;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $prodiTI = ProgramStudi::where('kode', 'TI')->first();
        $tahunAkademik = TahunAkademik::where('is_aktif', true)->first();

        // 1. Roles and Base Users
        User::updateOrCreate(['email' => 'admin@simta.ac.id'], [
            'name' => 'Super Admin SIMTA',
            'password' => Hash::make('password'),
            'role' => User::ROLE_SUPER_ADMIN,
            'is_active' => true,
        ]);

        User::updateOrCreate(['email' => 'pengelola@simta.ac.id'], [
            'name' => 'Pengelola Skripsi',
            'password' => Hash::make('password'),
            'role' => User::ROLE_PENGELOLA,
            'is_active' => true,
        ]);

        $kaprodiUser = User::updateOrCreate(['email' => 'kaprodi@simta.ac.id'], [
            'name' => 'Dr. Ahmad Fauzi, M.Kom.',
            'password' => Hash::make('password'),
            'role' => User::ROLE_KAPRODI,
            'is_active' => true,
        ]);

        $dekanUser = User::updateOrCreate(['email' => 'dekan@simta.ac.id'], [
            'name' => 'Dr. Ir. H. Syahrul Ramadhan, M.T.',
            'password' => Hash::make('password'),
            'role' => User::ROLE_DEKAN,
            'is_active' => true,
        ]);

        // Dosen 1 (Pembimbing 1, Penguji 1)
        $dosenUser1 = User::updateOrCreate(['email' => 'dosen1@simta.ac.id'], [
            'name' => 'Dr. Budi Santoso, M.T.',
            'password' => Hash::make('password'),
            'role' => User::ROLE_DOSEN,
            'is_active' => true,
        ]);
        $dosen1 = Dosen::updateOrCreate(['user_id' => $dosenUser1->id], [
            'prodi_id' => $prodiTI?->id,
            'nidn' => '0101700001',
            'nama' => 'Budi Santoso',
            'gelar_depan' => 'Dr.',
            'gelar_belakang' => 'M.T.',
            'jabatan' => 'Lektor Kepala',
            'email' => 'dosen1@simta.ac.id',
            'is_aktif' => true,
        ]);

        // Dosen 2 (Pembimbing 2, Penguji 2)
        $dosenUser2 = User::updateOrCreate(['email' => 'dosen2@simta.ac.id'], [
            'name' => 'Ir. Citra Lestari, M.Kom.',
            'password' => Hash::make('password'),
            'role' => User::ROLE_DOSEN,
            'is_active' => true,
        ]);
        $dosen2 = Dosen::updateOrCreate(['user_id' => $dosenUser2->id], [
            'prodi_id' => $prodiTI?->id,
            'nidn' => '0101700002',
            'nama' => 'Citra Lestari',
            'gelar_depan' => 'Ir.',
            'gelar_belakang' => 'M.Kom.',
            'jabatan' => 'Lektor',
            'email' => 'dosen2@simta.ac.id',
            'is_aktif' => true,
        ]);

        // Dosen 3 (Penguji 3)
        $dosenUser3 = User::updateOrCreate(['email' => 'dosen3@simta.ac.id'], [
            'name' => 'Prof. Dr. Hendra Wijaya',
            'password' => Hash::make('password'),
            'role' => User::ROLE_DOSEN,
            'is_active' => true,
        ]);
        $dosen3 = Dosen::updateOrCreate(['user_id' => $dosenUser3->id], [
            'prodi_id' => $prodiTI?->id,
            'nidn' => '0101700003',
            'nama' => 'Hendra Wijaya',
            'gelar_depan' => 'Prof. Dr.',
            'jabatan' => 'Guru Besar',
            'email' => 'dosen3@simta.ac.id',
            'is_aktif' => true,
        ]);

        // -------------------------------------------------------------
        // MAHASISWA 1: STAGE = BIMBINGAN / SIAP UJIAN
        // -------------------------------------------------------------
        $mhsUser1 = User::updateOrCreate(['email' => 'mahasiswa@simta.ac.id'], [
            'name' => 'Ahmad Rizky Maulana',
            'password' => Hash::make('password'),
            'role' => User::ROLE_MAHASISWA,
            'is_active' => true,
        ]);
        $mhs1 = Mahasiswa::updateOrCreate(['user_id' => $mhsUser1->id], [
            'prodi_id' => $prodiTI?->id,
            'nim' => '2021100001',
            'nama' => 'Ahmad Rizky Maulana',
            'angkatan' => '2021',
            'semester' => 7,
            'email' => 'mahasiswa@simta.ac.id',
            'status_skripsi' => Mahasiswa::STATUS_BIMBINGAN,
        ]);

        $skripsi1 = Skripsi::updateOrCreate(['mahasiswa_id' => $mhs1->id], [
            'tahun_akademik_id' => $tahunAkademik?->id,
            'judul' => 'Rancang Bangun Sistem Informasi Manajemen Skripsi Terintegrasi Berbasis Web (Studi Kasus: FT UMMU)',
            'deskripsi' => 'Pengembangan platform SIMTA untuk otomatisasi alur administrasi skripsi dan yudisium.',
            'bidang_kajian' => 'Sistem Informasi & Software Engineering',
            'tanggal_pengajuan' => now()->subDays(60),
            'tanggal_mulai' => now()->subDays(50),
            'status' => 'aktif',
        ]);

        Pembimbing::updateOrCreate(['skripsi_id' => $skripsi1->id, 'urutan' => 1], [
            'dosen_id' => $dosen1->id, 'status' => 'aktif', 'tanggal_disetujui' => now()->subDays(50)
        ]);
        Pembimbing::updateOrCreate(['skripsi_id' => $skripsi1->id, 'urutan' => 2], [
            'dosen_id' => $dosen2->id, 'status' => 'aktif', 'tanggal_disetujui' => now()->subDays(50)
        ]);

        SkPembimbing::updateOrCreate(['skripsi_id' => $skripsi1->id], [
            'nomor_sk' => 'SK.PEMB/FT-UMMU/2026/001', 'tanggal_sk' => now()->subDays(45),
            'status' => 'disetujui', 'approved_by' => $dekanUser->id, 'approved_at' => now()->subDays(45),
            'catatan' => 'SK telah diperiksa dan sesuai dengan distribusi beban dosen.'
        ]);

        // Dokumen Terunggah
        Dokumen::updateOrCreate(['skripsi_id' => $skripsi1->id, 'jenis' => 'draft_proposal'], [
            'uploaded_by' => $mhsUser1->id, 'nama' => 'Draft Proposal Bab 1-3.pdf',
            'file_path' => 'dokumen/dummy.pdf', 'file_size' => 1024,
            'status' => 'approved', 'uploaded_at' => now()->subDays(40)
        ]);

        // Bimbingan
        Bimbingan::updateOrCreate(['skripsi_id' => $skripsi1->id, 'mahasiswa_id' => $mhs1->id, 'topik' => 'Revisi Bab I - Pendahuluan'], [
            'dosen_id' => $dosen1->id, 'bab_bimbingan' => 'Bab I - Pendahuluan',
            'catatan_mahasiswa' => 'Permintaan masukan', 'catatan_dosen' => 'Perbaiki referensi.',
            'status' => 'disetujui', 'tanggal_bimbingan' => now()->subDays(35)
        ]);
        Bimbingan::updateOrCreate(['skripsi_id' => $skripsi1->id, 'mahasiswa_id' => $mhs1->id, 'topik' => 'Diskusi Metodologi'], [
            'dosen_id' => $dosen2->id, 'bab_bimbingan' => 'Bab III - Metodologi',
            'catatan_mahasiswa' => 'Metode apa?', 'catatan_dosen' => 'Gunakan metode Agile.',
            'status' => 'pending', 'tanggal_bimbingan' => now()->subDays(2)
        ]);

        // Upcoming Ujian Proposal (Dijadwalkan)
        $ujianProps1 = Ujian::updateOrCreate(['skripsi_id' => $skripsi1->id, 'tempat' => 'Kampus B UMMU'], [
            'jadwal' => now()->addDays(2), 'ruangan' => 'R. Sidang Utama FT',
            'status' => 'dijadwalkan', 'dijadwalkan_oleh' => $kaprodiUser->id
        ]);
        Penguji::updateOrCreate(['ujian_id' => $ujianProps1->id, 'dosen_id' => $dosen3->id], ['peran' => 'ketua']);


        // -------------------------------------------------------------
        // MAHASISWA 2: STAGE = SELESAI (SUDAH YUDISIUM)
        // -------------------------------------------------------------
        $mhsUser2 = User::updateOrCreate(['email' => 'mahasiswa2@simta.ac.id'], [
            'name' => 'Siti Nur Aisyah',
            'password' => Hash::make('password'),
            'role' => User::ROLE_MAHASISWA,
            'is_active' => true,
        ]);
        $mhs2 = Mahasiswa::updateOrCreate(['user_id' => $mhsUser2->id], [
            'prodi_id' => $prodiTI?->id,
            'nim' => '2021100002',
            'nama' => 'Siti Nur Aisyah',
            'angkatan' => '2021',
            'semester' => 8,
            'email' => 'mahasiswa2@simta.ac.id',
            'status_skripsi' => Mahasiswa::STATUS_SELESAI,
        ]);

        $skripsi2 = Skripsi::updateOrCreate(['mahasiswa_id' => $mhs2->id], [
            'tahun_akademik_id' => $tahunAkademik?->id,
            'judul' => 'Analisis Kinerja Aplikasi Berbasis Cloud untuk Mendukung Proses Akademik',
            'deskripsi' => 'Studi implementasi cloud.', 'bidang_kajian' => 'Sistem Terdistribusi',
            'tanggal_pengajuan' => now()->subMonths(6), 'tanggal_mulai' => now()->subMonths(5),
            'status' => 'selesai',
        ]);

        Pembimbing::updateOrCreate(['skripsi_id' => $skripsi2->id, 'urutan' => 1], [
            'dosen_id' => $dosen1->id, 'status' => 'aktif', 'tanggal_disetujui' => now()->subMonths(5)
        ]);
        Pembimbing::updateOrCreate(['skripsi_id' => $skripsi2->id, 'urutan' => 2], [
            'dosen_id' => $dosen2->id, 'status' => 'aktif', 'tanggal_disetujui' => now()->subMonths(5)
        ]);

        SkPembimbing::updateOrCreate(['skripsi_id' => $skripsi2->id], [
            'nomor_sk' => 'SK.PEMB/FT-UMMU/2026/002', 'tanggal_sk' => now()->subMonths(4),
            'status' => 'disetujui', 'approved_by' => $dekanUser->id, 'approved_at' => now()->subMonths(4),
            'catatan' => 'Kuota dosen mencukupi, disetujui.'
        ]);

        // Dokumen Lengkap
        foreach(['draft_proposal', 'draft_skripsi', 'lampiran_penelitian'] as $jenis) {
            Dokumen::updateOrCreate(['skripsi_id' => $skripsi2->id, 'jenis' => $jenis], [
                'uploaded_by' => $mhsUser2->id, 'nama' => "Draft {$jenis} Final.pdf",
                'file_path' => 'dokumen/dummy.pdf', 'file_size' => 2048,
                'status' => 'approved', 'uploaded_at' => now()->subMonths(2)
            ]);
        }

        // Bimbingan Historis
        for($i = 1; $i <= 5; $i++) {
            Bimbingan::updateOrCreate(['skripsi_id' => $skripsi2->id, 'topik' => "Bimbingan Tahap $i"], [
                'mahasiswa_id' => $mhs2->id, 'dosen_id' => $dosen1->id,
                'bab_bimbingan' => "Bab $i", 'catatan_mahasiswa' => "Penyerahan bab $i",
                'catatan_dosen' => "Sudah baik, lanjut bab berikutnya.",
                'status' => 'disetujui', 'tanggal_bimbingan' => now()->subMonths(4)->addDays($i * 10)
            ]);
        }

        // Ujian (Sudah Selesai)
        $ujianSidang = Ujian::updateOrCreate(['skripsi_id' => $skripsi2->id, 'jadwal' => now()->subDays(20)], [
            'tempat' => 'Kampus B', 'ruangan' => 'R. Sidang 2',
            'status' => 'selesai', 'dijadwalkan_oleh' => $kaprodiUser->id
        ]);
        
        $p1 = Penguji::updateOrCreate(['ujian_id' => $ujianSidang->id, 'dosen_id' => $dosen3->id], ['peran' => 'ketua']);
        $p2 = Penguji::updateOrCreate(['ujian_id' => $ujianSidang->id, 'dosen_id' => $dosen1->id], ['peran' => 'anggota']);

        SkPenguji::updateOrCreate(['ujian_id' => $ujianSidang->id], [
            'nomor_sk' => 'SK.PENGUJI/FT-UMMU/2026/012', 'tanggal_sk' => now()->subDays(25),
            'status' => 'disetujui', 'approved_by' => $dekanUser->id, 'approved_at' => now()->subDays(25),
            'catatan' => 'Formasi tim penguji sudah sesuai dengan bidang kajian.'
        ]);

        NilaiUjian::updateOrCreate(['ujian_id' => $ujianSidang->id, 'penguji_id' => $p1->id], ['nilai_penguasaan_materi' => 88, 'nilai_kemampuan_presentasi' => 90, 'nilai_penulisan' => 85, 'nilai_total' => 88, 'catatan' => 'Sangat memuaskan']);
        NilaiUjian::updateOrCreate(['ujian_id' => $ujianSidang->id, 'penguji_id' => $p2->id], ['nilai_penguasaan_materi' => 85, 'nilai_kemampuan_presentasi' => 85, 'nilai_penulisan' => 85, 'nilai_total' => 85, 'catatan' => 'Baik']);

        BeritaAcara::updateOrCreate(['ujian_id' => $ujianSidang->id], [
            'nomor_ba' => 'BA/SIDANG/FT/2026/009',
            'nilai_akhir' => 86.5, 'predikat' => 'A',
            'keputusan' => 'lulus', 'rekomendasi' => 'Tidak ada revisi major',
            'status' => 'final', 'approved_by' => $kaprodiUser->id, 'approved_at' => now()->subDays(20),
        ]);

        LembarPengesahan::updateOrCreate(['skripsi_id' => $skripsi2->id], [
            'file_scan' => 'pengesahan/dummy.pdf', 'status' => 'disetujui',
            'verified_by' => $kaprodiUser->id, 'verified_at' => now()->subDays(15), 'catatan' => 'Telah ditandatangani lengkap'
        ]);

        $periodeYudisium = \App\Models\PeriodeYudisium::firstOrCreate(
            ['nama_periode' => 'Gelombang 1 2026/2027'],
            ['tahun' => '2026', 'is_aktif' => true, 'status' => 'buka']
        );

        PendaftaranYudisium::updateOrCreate(['mahasiswa_id' => $mhs2->id], [
            'periode_id' => $periodeYudisium->id,
            'tanggal_daftar' => now()->subDays(10),
            'status' => 'eligible',
            'catatan' => 'Lengkap, siap ikut yudisium.', 'verified_by' => $kaprodiUser->id, 'verified_at' => now()->subDays(5)
        ]);
        
        // -------------------------------------------------------------
        // MAHASISWA 3: STAGE = BARU DAFTAR (BELUM ADA SKRIPSI)
        // -------------------------------------------------------------
        $mhsUser3 = User::updateOrCreate(['email' => 'mahasiswa3@simta.ac.id'], [
            'name' => 'Dimas Anggara',
            'password' => Hash::make('password'),
            'role' => User::ROLE_MAHASISWA,
            'is_active' => true,
        ]);
        Mahasiswa::updateOrCreate(['user_id' => $mhsUser3->id], [
            'prodi_id' => $prodiTI?->id,
            'nim' => '2021100003',
            'nama' => 'Dimas Anggara',
            'angkatan' => '2021',
            'semester' => 7,
            'email' => 'mahasiswa3@simta.ac.id',
            'status_skripsi' => Mahasiswa::STATUS_BELUM_DAFTAR,
        ]);
    }
}
