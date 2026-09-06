<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Bimbingan;
use App\Models\Pembimbing;
use Illuminate\Http\Request;

class BimbinganController extends Controller
{
    public function index(Request $request)
    {
        $dosen = $request->user()->dosen;

        $bimbinganList = $dosen
            ? Pembimbing::where('dosen_id', $dosen->id)
                ->with(['skripsi.mahasiswa.prodi', 'skripsi.bimbingan', 'dosen'])
                ->latest('tanggal_disetujui')
                ->get()
            : collect();

        $consultationRequests = $dosen
            ? Bimbingan::where('dosen_id', $dosen->id)
                ->with(['skripsi.mahasiswa.prodi', 'mahasiswa'])
                ->latest('tanggal_bimbingan')
                ->get()
            : collect();

        return view('dosen.bimbingan.index', compact('bimbinganList', 'consultationRequests'));
    }

    public function show(Pembimbing $bimbingan)
    {
        $bimbingan->load([
            'skripsi.mahasiswa.prodi',
            'skripsi.tahunAkademik',
            'skripsi.ujian',
            'skripsi.lembarPengesahan',
            'skripsi.dokumen',
            'dosen',
        ]);

        $consultations = Bimbingan::where('skripsi_id', $bimbingan->skripsi_id)
            ->where('dosen_id', $bimbingan->dosen_id)
            ->latest('tanggal_bimbingan')
            ->get();

        $progress = 0;
        $totalSteps = 5;
        if ($bimbingan->skripsi?->status === 'aktif') {
            $progress = 40;
        }
        if ($bimbingan->skripsi?->status === 'selesai') {
            $progress = 100;
        }
        if ($consultations->count() > 0) {
            $progress = min(85, 35 + ($consultations->count() * 10));
        }

        return view('dosen.bimbingan.show', compact('bimbingan', 'consultations', 'progress', 'totalSteps'));
    }

    public function respond(Request $request, Bimbingan $bimbingan)
    {
        $request->validate([
            'status' => 'required|in:approved,revision,rejected,completed',
            'catatan_dosen' => 'nullable|string|max:1000',
        ]);

        $bimbingan->update([
            'status' => $request->status,
            'catatan_dosen' => $request->catatan_dosen ?? $bimbingan->catatan_dosen,
        ]);

        return redirect()->back()->with('success', 'Respon bimbingan berhasil disimpan.');
    }
}
