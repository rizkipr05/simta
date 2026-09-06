<?php

namespace App\Http\Controllers\Dekan;

use App\Http\Controllers\Controller;
use App\Models\SkPembimbing;
use App\Models\SkPenguji;

class DashboardController extends Controller
{
    public function index()
    {
        $pendingSkPembimbing = SkPembimbing::where('status', 'diajukan')
            ->with('skripsi.mahasiswa.prodi', 'skripsi.pembimbing.dosen')
            ->latest()
            ->limit(5)
            ->get();

        $pendingSkPenguji = SkPenguji::where('status', 'diajukan')
            ->with('ujian.skripsi.mahasiswa.prodi', 'ujian.penguji.dosen')
            ->latest()
            ->limit(5)
            ->get();

        $stats = [
            'pending_sk' => SkPembimbing::where('status', 'diajukan')->count() + SkPenguji::where('status', 'diajukan')->count(),
            'approved_sk' => SkPembimbing::where('status', 'disetujui')->count() + SkPenguji::where('status', 'disetujui')->count(),
            'rejected_sk' => SkPembimbing::where('status', 'ditolak')->count() + SkPenguji::where('status', 'ditolak')->count(),
            'documents_to_review' => SkPembimbing::where('status', 'diajukan')->count() + SkPenguji::where('status', 'diajukan')->count(),
        ];

        $recentActivities = collect()
            ->merge(
                $pendingSkPembimbing->map(fn ($sk) => [
                    'title' => 'SK Pembimbing menunggu persetujuan',
                    'label' => $sk->nomor_sk ?? 'Draft SK',
                    'description' => $sk->skripsi?->mahasiswa?->nama ?? 'Mahasiswa',
                    'status' => 'Menunggu',
                    'date' => $sk->created_at,
                ])
            )
            ->merge(
                $pendingSkPenguji->map(fn ($sk) => [
                    'title' => 'SK Penguji menunggu persetujuan',
                    'label' => $sk->nomor_sk ?? 'Draft SK',
                    'description' => $sk->ujian?->skripsi?->mahasiswa?->nama ?? 'Mahasiswa',
                    'status' => 'Menunggu',
                    'date' => $sk->created_at,
                ])
            )
            ->merge(
                SkPembimbing::whereIn('status', ['disetujui', 'ditolak'])
                    ->with('skripsi.mahasiswa')
                    ->latest('approved_at')
                    ->limit(2)
                    ->get()
                    ->map(fn ($sk) => [
                        'title' => $sk->status === 'disetujui' ? 'SK Pembimbing disetujui' : 'SK Pembimbing ditolak',
                        'label' => $sk->nomor_sk ?? 'Draft SK',
                        'description' => $sk->skripsi?->mahasiswa?->nama ?? 'Mahasiswa',
                        'status' => $sk->status === 'disetujui' ? 'Disetujui' : 'Ditolak',
                        'date' => $sk->approved_at ?? $sk->updated_at,
                    ])
            )
            ->merge(
                SkPenguji::whereIn('status', ['disetujui', 'ditolak'])
                    ->with('ujian.skripsi.mahasiswa')
                    ->latest('approved_at')
                    ->limit(2)
                    ->get()
                    ->map(fn ($sk) => [
                        'title' => $sk->status === 'disetujui' ? 'SK Penguji disetujui' : 'SK Penguji ditolak',
                        'label' => $sk->nomor_sk ?? 'Draft SK',
                        'description' => $sk->ujian?->skripsi?->mahasiswa?->nama ?? 'Mahasiswa',
                        'status' => $sk->status === 'disetujui' ? 'Disetujui' : 'Ditolak',
                        'date' => $sk->approved_at ?? $sk->updated_at,
                    ])
            )
            ->sortByDesc('date')
            ->take(6)
            ->values();

        return view('dekan.dashboard', compact('pendingSkPembimbing', 'pendingSkPenguji', 'stats', 'recentActivities'));
    }
}
