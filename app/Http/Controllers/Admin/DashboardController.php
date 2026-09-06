<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\PendaftaranYudisium;
use App\Models\Skripsi;
use App\Models\Ujian;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_mahasiswa' => Mahasiswa::count(),
            'total_dosen' => Dosen::count(),
            'total_skripsi' => Skripsi::count(),
            'total_yudisium' => PendaftaranYudisium::count(),
            'pending_pengajuan' => Skripsi::where('status', 'pengajuan')->count(),
            'pending_verifikasi' => User::where('is_active', true)->count(),
        ];

        $skripsiStatusBreakdown = [
            'pengajuan' => Skripsi::where('status', 'pengajuan')->count(),
            'aktif' => Skripsi::where('status', 'aktif')->count(),
            'selesai' => Skripsi::where('status', 'selesai')->count(),
            'ditolak' => Skripsi::where('status', 'ditolak')->count(),
        ];

        $nearestExam = Ujian::with(['skripsi.mahasiswa'])
            ->where('jadwal', '>=', now())
            ->orderBy('jadwal')
            ->first();

        $recentActivities = AuditLog::with('user')
            ->latest('created_at')
            ->limit(6)
            ->get();

        $shortcuts = [
            ['label' => 'Manajemen User & Role', 'route' => 'admin.users.index', 'icon' => '👥', 'color' => 'emerald'],
            ['label' => 'Pengelolaan Skripsi', 'route' => 'admin.skripsi.index', 'icon' => '📄', 'color' => 'teal'],
            ['label' => 'Penetapan Pembimbing', 'route' => 'admin.sk-pembimbing.index', 'icon' => '🧑‍🏫', 'color' => 'sky'],
            ['label' => 'Jadwal Ujian', 'route' => 'admin.ujian.index', 'icon' => '📅', 'color' => 'amber'],
            ['label' => 'Yudisium', 'route' => 'admin.yudisium.index', 'icon' => '🏅', 'color' => 'violet'],
            ['label' => 'Pengaturan Sistem', 'route' => 'admin.settings.index', 'icon' => '⚙️', 'color' => 'slate'],
        ];

        return view('admin.dashboard', compact(
            'stats',
            'skripsiStatusBreakdown',
            'nearestExam',
            'recentActivities',
            'shortcuts'
        ));
    }
}
