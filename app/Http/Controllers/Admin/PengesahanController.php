<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LembarPengesahan;
use App\Models\Mahasiswa;
use App\Models\Setting;
use App\Models\Skripsi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PengesahanController extends Controller
{
    public function index()
    {
        $pengesahanList = LembarPengesahan::with(['skripsi.mahasiswa.prodi'])->latest()->paginate(20);

        return view('admin.pengesahan.index', compact('pengesahanList'));
    }

    public function create()
    {
        $skripsiList = Skripsi::whereHas('mahasiswa', fn ($q) => $q->where('status_skripsi', Mahasiswa::STATUS_MENUNGGU_PENGESAHAN))
            ->doesntHave('lembarPengesahan')->with('mahasiswa')->get();

        return view('admin.pengesahan.create', compact('skripsiList'));
    }

    public function store(Request $request)
    {
        $request->validate(['skripsi_id' => 'required|exists:skripsi,id']);
        LembarPengesahan::create(['skripsi_id' => $request->skripsi_id, 'status' => 'draft']);

        return redirect()->route('admin.pengesahan.index')->with('success', 'Draft Lembar Pengesahan dibuat.');
    }

    public function show(LembarPengesahan $pengesahan)
    {
        $pengesahan->load(['skripsi.mahasiswa.prodi', 'skripsi.pembimbing.dosen', 'verifiedBy']);

        return view('admin.pengesahan.show', compact('pengesahan'));
    }

    public function edit(LembarPengesahan $pengesahan)
    {
        return view('admin.pengesahan.edit', compact('pengesahan'));
    }

    public function update(Request $request, LembarPengesahan $pengesahan)
    {
        $request->validate(['catatan' => 'nullable|string']);
        if ($request->hasFile('file_scan')) {
            $path = $request->file('file_scan')->store('pengesahan/scan', 'public');
            $pengesahan->update(['file_scan' => $path, 'status' => 'diupload']);
        }
        $pengesahan->update(['catatan' => $request->catatan]);

        return redirect()->back()->with('success', 'Data diperbarui.');
    }

    public function destroy(LembarPengesahan $pengesahan)
    {
        $pengesahan->delete();

        return redirect()->route('admin.pengesahan.index')->with('success', 'Lembar Pengesahan dihapus.');
    }

    public function verifikasi(Request $request, LembarPengesahan $pengesahan)
    {
        $pengesahan->update([
            'status' => 'terverifikasi',
            'verified_by' => auth()->id(),
            'verified_at' => now(),
        ]);
        $pengesahan->skripsi?->mahasiswa?->update(['status_skripsi' => Mahasiswa::STATUS_PENGESAHAN_TERVERIFIKASI]);

        return redirect()->back()->with('success', 'Lembar pengesahan terverifikasi. Mahasiswa eligible yudisium.');
    }

    public function pdf(LembarPengesahan $pengesahan)
    {
        $pengesahan->load(['skripsi.mahasiswa.prodi', 'skripsi.pembimbing.dosen']);
        $settings = Setting::all()->pluck('value', 'key');
        $pdf = Pdf::loadView('pdf.lembar-pengesahan', compact('pengesahan', 'settings'))->setPaper('a4');
        $nim = $pengesahan->skripsi?->mahasiswa?->nim ?? 'export';

        return $pdf->download("Lembar_Pengesahan_{$nim}.pdf");
    }
}
