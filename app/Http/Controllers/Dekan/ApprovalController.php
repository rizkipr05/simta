<?php

namespace App\Http\Controllers\Dekan;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\SkPembimbing;
use App\Models\SkPenguji;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    public function index()
    {
        $skPembimbingList = SkPembimbing::where('status', 'diajukan')
            ->with('skripsi.mahasiswa.prodi', 'skripsi.pembimbing.dosen', 'approvedBy')
            ->latest()
            ->paginate(10, ['*'], 'sk_page');

        $skPengujiList = SkPenguji::where('status', 'diajukan')
            ->with('ujian.skripsi.mahasiswa.prodi', 'ujian.penguji.dosen', 'approvedBy')
            ->latest()
            ->paginate(10, ['*'], 'skp_page');

        $historySkPembimbingList = SkPembimbing::whereIn('status', ['disetujui', 'ditolak'])
            ->with('skripsi.mahasiswa.prodi', 'approvedBy')
            ->latest('approved_at')
            ->limit(10)
            ->get();

        $historySkPengujiList = SkPenguji::whereIn('status', ['disetujui', 'ditolak'])
            ->with('ujian.skripsi.mahasiswa.prodi', 'approvedBy')
            ->latest('approved_at')
            ->limit(10)
            ->get();

        return view('dekan.approvals', compact(
            'skPembimbingList',
            'skPengujiList',
            'historySkPembimbingList',
            'historySkPengujiList'
        ));
    }

    public function approveSk(Request $request, SkPembimbing $skPembimbing)
    {
        $skPembimbing->update([
            'status' => 'disetujui',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'catatan' => $request->catatan ?? $skPembimbing->catatan,
        ]);
        $skPembimbing->skripsi->mahasiswa->update(['status_skripsi' => Mahasiswa::STATUS_SK_PEMBIMBING_DISAHKAN]);

        return redirect()->back()->with('success', 'SK Pembimbing disetujui. Mahasiswa bisa mulai bimbingan.');
    }

    public function rejectSk(Request $request, SkPembimbing $skPembimbing)
    {
        $request->validate(['catatan' => 'required|string|min:5']);
        $skPembimbing->update([
            'status' => 'ditolak',
            'catatan' => $request->catatan,
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return redirect()->back()->with('error', 'SK Pembimbing ditolak.');
    }

    public function approveSkPenguji(Request $request, SkPenguji $skPenguji)
    {
        $skPenguji->update([
            'status' => 'disetujui',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'catatan' => $request->catatan ?? $skPenguji->catatan,
        ]);

        return redirect()->back()->with('success', 'SK Penguji disetujui.');
    }

    public function rejectSkPenguji(Request $request, SkPenguji $skPenguji)
    {
        $request->validate(['catatan' => 'required|string|min:5']);
        $skPenguji->update([
            'status' => 'ditolak',
            'catatan' => $request->catatan,
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return redirect()->back()->with('error', 'SK Penguji ditolak.');
    }
}
