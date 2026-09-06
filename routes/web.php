<?php

use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\BeritaAcaraController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
// Admin / Pengelola
use App\Http\Controllers\Admin\DokumenRepositoryController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\MasterData\DosenController;
use App\Http\Controllers\Admin\MasterData\MahasiswaController;
use App\Http\Controllers\Admin\MasterData\ProgramStudiController;
use App\Http\Controllers\Admin\MasterData\TahunAkademikController;
use App\Http\Controllers\Admin\PembimbingController;
use App\Http\Controllers\Admin\PengesahanController;
use App\Http\Controllers\Admin\PengujiController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SkPembimbingController;
use App\Http\Controllers\Admin\SkPengujiController;
use App\Http\Controllers\Admin\SkripsiController;
use App\Http\Controllers\Admin\UjianController;
use App\Http\Controllers\Admin\UserController;
// Dekan
use App\Http\Controllers\Admin\YudisiumController as AdminYudisiumController;
use App\Http\Controllers\DashboardController;
// Kaprodi
use App\Http\Controllers\Dekan\ApprovalController as DekanApproval;
use App\Http\Controllers\Dekan\DashboardController as DekanDashboard;
// Dosen
use App\Http\Controllers\Dosen\BimbinganController;
use App\Http\Controllers\Dosen\DashboardController as DosenDashboard;
use App\Http\Controllers\Dosen\EvidenceController;
use App\Http\Controllers\Dosen\NilaiController;
// Mahasiswa
use App\Http\Controllers\Kaprodi\DashboardController as KaprodiDashboard;
use App\Http\Controllers\Kaprodi\MonitoringController;
use App\Http\Controllers\Mahasiswa\DashboardController as MahasiswaDashboard;
use App\Http\Controllers\Mahasiswa\DokumenController;
use App\Http\Controllers\Mahasiswa\NotifikasiController;
use App\Http\Controllers\Mahasiswa\PengajuanController;
use App\Http\Controllers\Mahasiswa\RiwayatController;

use App\Http\Controllers\Mahasiswa\UploadScanController;
use App\Http\Controllers\Mahasiswa\YudisiumController as MahasiswaYudisium;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ───────────────────────────────────────────────────────────────
// Public / Auth routes (Breeze)
// ───────────────────────────────────────────────────────────────
Route::get('/', function () {
    return redirect()->route('login');
});

require __DIR__.'/auth.php';

// ───────────────────────────────────────────────────────────────
// Authenticated routes
// ───────────────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {

    // Universal dashboard redirect based on role
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile (all roles)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ─── SUPER ADMIN & PENGELOLA SKRIPSI ───────────────────────
    Route::prefix('admin')->name('admin.')->middleware(['role:super_admin,pengelola_skripsi'])->group(function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // User Management
        Route::resource('users', UserController::class);

        // Dokumen Repository
        Route::get('dokumen', [DokumenRepositoryController::class, 'index'])->name('dokumen.index');

        // Audit Log
        Route::get('audit-log', [AuditLogController::class, 'index'])->name('audit-log.index');

        // Master Data
        Route::prefix('master')->name('master.')->group(function () {
            Route::resource('program-studi', ProgramStudiController::class)->parameters(['program-studi' => 'programStudi']);
            Route::resource('dosen', DosenController::class);
            Route::resource('mahasiswa', MahasiswaController::class);
            Route::resource('tahun-akademik', TahunAkademikController::class);
            Route::post('tahun-akademik/{tahunAkademik}/set-aktif', [TahunAkademikController::class, 'setAktif'])->name('tahun-akademik.set-aktif');
        });

        // Skripsi
        Route::resource('skripsi', SkripsiController::class)->except(['create', 'store']);
        Route::patch('skripsi/{skripsi}/terima', [SkripsiController::class, 'terima'])->name('skripsi.terima');
        Route::patch('skripsi/{skripsi}/tolak', [SkripsiController::class, 'tolak'])->name('skripsi.tolak');

        // Pembimbing
        Route::post('skripsi/{skripsi}/pembimbing', [PembimbingController::class, 'store'])->name('pembimbing.store');
        Route::delete('pembimbing/{pembimbing}', [PembimbingController::class, 'destroy'])->name('pembimbing.destroy');

        // SK Pembimbing
        Route::resource('sk-pembimbing', SkPembimbingController::class)->except(['create', 'edit']);
        Route::post('sk-pembimbing/{skPembimbing}/generate', [SkPembimbingController::class, 'generate'])->name('sk-pembimbing.generate');
        Route::get('sk-pembimbing/{skPembimbing}/pdf', [SkPembimbingController::class, 'pdf'])->name('sk-pembimbing.pdf');
        Route::post('sk-pembimbing/{skPembimbing}/ajukan', [SkPembimbingController::class, 'ajukan'])->name('sk-pembimbing.ajukan');

        // Ujian
        Route::resource('ujian', UjianController::class);
        Route::post('ujian/{ujian}/penguji', [PengujiController::class, 'store'])->name('penguji.store');
        Route::delete('penguji/{penguji}', [PengujiController::class, 'destroy'])->name('penguji.destroy');
        Route::get('ujian/{ujian}/undangan-pdf', [UjianController::class, 'undanganPdf'])->name('ujian.undangan-pdf');

        // SK Penguji
        Route::post('ujian/{ujian}/sk-penguji/generate', [SkPengujiController::class, 'generate'])->name('sk-penguji.generate');
        Route::get('sk-penguji/{skPenguji}/pdf', [SkPengujiController::class, 'pdf'])->name('sk-penguji.pdf');

        // Berita Acara
        Route::resource('berita-acara', BeritaAcaraController::class);
        Route::post('berita-acara/{beritaAcara}/generate', [BeritaAcaraController::class, 'generate'])->name('berita-acara.generate');
        Route::get('berita-acara/{beritaAcara}/pdf', [BeritaAcaraController::class, 'pdf'])->name('berita-acara.pdf');
        Route::post('berita-acara/{beritaAcara}/finalize', [BeritaAcaraController::class, 'finalize'])->name('berita-acara.finalize');

        // Pengesahan
        Route::resource('pengesahan', PengesahanController::class);
        Route::get('pengesahan/{pengesahan}/pdf', [PengesahanController::class, 'pdf'])->name('pengesahan.pdf');
        Route::post('pengesahan/{pengesahan}/verifikasi', [PengesahanController::class, 'verifikasi'])->name('pengesahan.verifikasi');

        // Yudisium
        Route::resource('yudisium', AdminYudisiumController::class);
        Route::patch('yudisium/pendaftaran/{pendaftaran}/verifikasi', [AdminYudisiumController::class, 'verifikasi'])->name('yudisium.verifikasi');
        Route::patch('yudisium/berkas/{berkas}/approve', [AdminYudisiumController::class, 'approveberkas'])->name('yudisium.berkas.approve');

        // Settings
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('settings', [SettingController::class, 'update'])->name('settings.update');

        // Laporan
        Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('laporan/rekap-skripsi', [LaporanController::class, 'rekapSkripsi'])->name('laporan.rekap-skripsi');
        Route::get('laporan/rekap-yudisium', [LaporanController::class, 'rekapYudisium'])->name('laporan.rekap-yudisium');
    });

    // ─── DEKAN ─────────────────────────────────────────────────
    Route::prefix('dekan')->name('dekan.')->middleware(['role:dekan'])->group(function () {
        Route::get('dashboard', [DekanDashboard::class, 'index'])->name('dashboard');
        Route::get('approvals', [DekanApproval::class, 'index'])->name('approvals.index');
        Route::post('approvals/sk-pembimbing/{skPembimbing}/approve', [DekanApproval::class, 'approveSk'])->name('approvals.sk-pembimbing.approve');
        Route::post('approvals/sk-pembimbing/{skPembimbing}/reject', [DekanApproval::class, 'rejectSk'])->name('approvals.sk-pembimbing.reject');
        Route::post('approvals/sk-penguji/{skPenguji}/approve', [DekanApproval::class, 'approveSkPenguji'])->name('approvals.sk-penguji.approve');
        Route::post('approvals/sk-penguji/{skPenguji}/reject', [DekanApproval::class, 'rejectSkPenguji'])->name('approvals.sk-penguji.reject');
        Route::get('sk-pembimbing/{skPembimbing}/pdf', [SkPembimbingController::class, 'pdf'])->name('sk-pembimbing.pdf');
        Route::get('sk-penguji/{skPenguji}/pdf', [SkPengujiController::class, 'pdf'])->name('sk-penguji.pdf');
    });

    // ─── KAPRODI ───────────────────────────────────────────────
    Route::prefix('kaprodi')->name('kaprodi.')->middleware(['role:kaprodi,super_admin'])->group(function () {
        Route::get('dashboard', [KaprodiDashboard::class, 'index'])->name('dashboard');
        Route::get('statistik', [MonitoringController::class, 'statistik'])->name('statistik.index');
        Route::get('monitoring', [MonitoringController::class, 'index'])->name('monitoring.index');
        Route::get('monitoring/{mahasiswa}', [MonitoringController::class, 'show'])->name('monitoring.show');
        Route::get('yudisium', [MonitoringController::class, 'yudisium'])->name('yudisium.index');
    });

    // ─── DOSEN ─────────────────────────────────────────────────
    Route::prefix('dosen')->name('dosen.')->middleware(['role:dosen'])->group(function () {
        Route::get('dashboard', [DosenDashboard::class, 'index'])->name('dashboard');
        Route::resource('bimbingan', BimbinganController::class)->only(['index', 'show']);
        Route::post('bimbingan/{bimbingan}/respond', [BimbinganController::class, 'respond'])->name('bimbingan.respond');
        Route::resource('nilai', NilaiController::class)->only(['index', 'show', 'store', 'update']);
        Route::get('evidence', [EvidenceController::class, 'index'])->name('evidence.index');
        Route::get('evidence/{file}/download', [EvidenceController::class, 'download'])->name('evidence.download');
    });

    // ─── MAHASISWA ─────────────────────────────────────────────
    Route::prefix('mahasiswa')->name('mahasiswa.')->middleware(['role:mahasiswa'])->group(function () {
        Route::get('dashboard', [MahasiswaDashboard::class, 'index'])->name('dashboard');

        // Bimbingan & Dokumen
        Route::get('bimbingan/create', [App\Http\Controllers\Mahasiswa\BimbinganController::class, 'create'])->name('bimbingan.create');
        Route::resource('bimbingan', App\Http\Controllers\Mahasiswa\BimbinganController::class)->only(['index', 'store', 'destroy']);
        Route::resource('dokumen', DokumenController::class)->only(['index', 'store', 'destroy']);

        // Pengajuan Skripsi
        Route::get('pengajuan', [PengajuanController::class, 'index'])->name('pengajuan.index');
        Route::post('pengajuan', [PengajuanController::class, 'store'])->name('pengajuan.store');
        Route::get('pengajuan/{skripsi}', [PengajuanController::class, 'show'])->name('pengajuan.show');
        Route::put('pengajuan/{skripsi}', [PengajuanController::class, 'update'])->name('pengajuan.update');
        Route::delete('pengajuan/{skripsi}', [PengajuanController::class, 'destroy'])->name('pengajuan.destroy');


        // Upload Scan / Pengesahan
        Route::get('pengesahan', [App\Http\Controllers\Mahasiswa\PengesahanController::class, 'index'])->name('pengesahan.index');
        Route::post('skripsi/{skripsi}/upload-pengesahan', [UploadScanController::class, 'uploadPengesahan'])->name('upload.pengesahan');
        Route::post('skripsi/{skripsi}/siap-ujian', [PengajuanController::class, 'siapUjian'])->name('skripsi.siap-ujian');

        // Yudisium
        Route::get('yudisium', [MahasiswaYudisium::class, 'index'])->name('yudisium.index');
        Route::post('yudisium/daftar', [MahasiswaYudisium::class, 'daftar'])->name('yudisium.daftar');
        Route::post('yudisium/berkas/{persyaratan}/upload', [MahasiswaYudisium::class, 'uploadBerkas'])->name('yudisium.upload');

        // Riwayat Pengajuan
        Route::get('riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');

        // Notifikasi
        Route::get('notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');
        Route::post('notifikasi/{notifikasi}/read', [NotifikasiController::class, 'markAsRead'])->name('notifikasi.read');
        Route::post('notifikasi/read-all', [NotifikasiController::class, 'markAllAsRead'])->name('notifikasi.read-all');
    });
});
