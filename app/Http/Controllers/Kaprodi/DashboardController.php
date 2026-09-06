<?php

namespace App\Http\Controllers\Kaprodi;

use App\Http\Controllers\Controller;
use App\Models\Bimbingan;
use App\Models\Mahasiswa;
use App\Models\PendaftaranYudisium;
use App\Models\Skripsi;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_mahasiswa_skripsi' => Mahasiswa::whereHas('skripsi')->count(),
            'skripsi_aktif' => Skripsi::where('status', 'aktif')->count(),
            'skripsi_selesai' => Skripsi::where('status', 'selesai')->count(),
            'pengajuan_judul' => Skripsi::where('status', 'pengajuan')->count(),
            'mahasiswa_bimbingan' => Mahasiswa::where('status_skripsi', Mahasiswa::STATUS_BIMBINGAN)->count(),
            'mahasiswa_siap_ujian' => Mahasiswa::where('status_skripsi', Mahasiswa::STATUS_SIAP_UJIAN)->count(),
            'yudisium' => PendaftaranYudisium::count(),
        ];

        $prodiProgress = Mahasiswa::with('prodi', 'skripsi')
            ->select('prodi_id', 'status_skripsi')
            ->get()
            ->groupBy('prodi_id')
            ->map(function ($items, $prodiId) {
                $prodi = $items->first()->prodi;

                return [
                    'nama' => $prodi?->nama ?? 'Prodi Tidak Diketahui',
                    'total' => $items->count(),
                    'aktif' => $items->filter(fn ($item) => optional($item->skripsi)->status === 'aktif')->count(),
                    'selesai' => $items->filter(fn ($item) => optional($item->skripsi)->status === 'selesai')->count(),
                    'pengajuan' => $items->filter(fn ($item) => optional($item->skripsi)->status === 'pengajuan')->count(),
                ];
            })
            ->values();

        $recentSkripsi = Skripsi::with(['mahasiswa.prodi', 'pembimbing1.dosen'])
            ->latest('tanggal_pengajuan')
            ->limit(8)
            ->get();

        return view('kaprodi.dashboard', compact('stats', 'prodiProgress', 'recentSkripsi'));
    }
}
