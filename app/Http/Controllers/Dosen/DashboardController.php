<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Bimbingan;
use App\Models\Pembimbing;
use App\Models\Penguji;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $dosen = $request->user()->dosen;

        $bimbinganCount = $dosen ? Pembimbing::where('dosen_id', $dosen->id)->count() : 0;
        $pendingBimbingan = $dosen ? Bimbingan::where('dosen_id', $dosen->id)->whereIn('status', ['pending', 'revision'])->count() : 0;
        $revisiCount = $dosen ? Bimbingan::where('dosen_id', $dosen->id)->where('status', 'revision')->count() : 0;
        $jadwalSidangCount = $dosen ? Penguji::where('dosen_id', $dosen->id)->count() : 0;
        $nilaiPending = $dosen ? Penguji::where('dosen_id', $dosen->id)->whereDoesntHave('nilai')->count() : 0;

        $recentBimbingan = $dosen
            ? Bimbingan::where('dosen_id', $dosen->id)->with('skripsi.mahasiswa')->latest('tanggal_bimbingan')->limit(5)->get()
            : collect();

        $recentActivities = $recentBimbingan->map(function ($bimbingan) {
            return [
                'title' => 'Bimbingan '.($bimbingan->status === 'revision' ? 'revisi' : 'baru'),
                'description' => $bimbingan->skripsi?->mahasiswa?->nama.' - '.$bimbingan->topik,
                'status' => strtoupper($bimbingan->status),
                'date' => $bimbingan->tanggal_bimbingan,
            ];
        })->values();

        $stats = [
            'total_bimbingan' => $bimbinganCount,
            'pending_bimbingan' => $pendingBimbingan,
            'revisi_mahasiswa' => $revisiCount,
            'jadwal_sidang' => $jadwalSidangCount,
            'tugas_penilaian' => $nilaiPending,
            'recent_activities' => $recentActivities,
        ];

        return view('dosen.dashboard', compact('dosen', 'bimbinganCount', 'pendingBimbingan', 'revisiCount', 'jadwalSidangCount', 'nilaiPending', 'recentBimbingan', 'recentActivities', 'stats'));
    }
}
