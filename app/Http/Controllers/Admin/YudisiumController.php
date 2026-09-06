<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BerkasYudisium;
use App\Models\Mahasiswa;
use App\Models\PendaftaranYudisium;
use App\Models\PeriodeYudisium;
use App\Models\PersyaratanYudisium;
use Illuminate\Http\Request;

class YudisiumController extends Controller
{
    public function index()
    {
        $periodeList = PeriodeYudisium::withCount('pendaftaran')->latest()->paginate(15);

        return view('admin.yudisium.index', compact('periodeList'));
    }

    public function create()
    {
        $persyaratanList = PersyaratanYudisium::orderBy('urutan')->get();

        return view('admin.yudisium.create', compact('persyaratanList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_periode' => 'required|string|max:255',
            'tahun' => 'required|string|max:10',
            'tanggal_buka_pendaftaran' => 'required|date',
            'tanggal_tutup_pendaftaran' => 'required|date|after:tanggal_buka_pendaftaran',
            'tanggal_yudisium' => 'nullable|date',
            'tempat' => 'nullable|string|max:255',
        ]);
        PeriodeYudisium::create(array_merge($validated, ['status' => 'buka']));

        return redirect()->route('admin.yudisium.index')->with('success', 'Periode yudisium dibuat.');
    }

    public function show(PeriodeYudisium $yudisium)
    {
        $yudisium->load(['pendaftaran.mahasiswa.prodi', 'pendaftaran.berkas.persyaratan']);

        return view('admin.yudisium.show', compact('yudisium'));
    }

    public function edit(PeriodeYudisium $yudisium)
    {
        return view('admin.yudisium.edit', compact('yudisium'));
    }

    public function update(Request $request, PeriodeYudisium $yudisium)
    {
        $validated = $request->validate([
            'nama_periode' => 'required|string|max:255',
            'tahun' => 'required|string|max:10',
            'tanggal_buka_pendaftaran' => 'required|date',
            'tanggal_tutup_pendaftaran' => 'required|date',
            'tanggal_yudisium' => 'nullable|date',
            'tempat' => 'nullable|string|max:255',
            'status' => 'required|in:persiapan,buka,tutup,selesai',
        ]);
        $yudisium->update($validated);

        return redirect()->route('admin.yudisium.index')->with('success', 'Periode yudisium diperbarui.');
    }

    public function destroy(PeriodeYudisium $yudisium)
    {
        $yudisium->delete();

        return redirect()->route('admin.yudisium.index')->with('success', 'Periode yudisium dihapus.');
    }

    public function verifikasi(Request $request, PendaftaranYudisium $pendaftaran)
    {
        $request->validate(['status' => 'required|in:eligible,ditolak', 'catatan' => 'nullable|string']);
        $pendaftaran->update([
            'status' => $request->status,
            'catatan' => $request->catatan,
            'verified_by' => auth()->id(),
            'verified_at' => now(),
        ]);
        if ($request->status === 'eligible') {
            $pendaftaran->mahasiswa->update(['status_skripsi' => Mahasiswa::STATUS_SELESAI]);
        }

        return redirect()->back()->with('success', 'Status pendaftaran yudisium diperbarui.');
    }

    public function approveberkas(Request $request, BerkasYudisium $berkas)
    {
        $request->validate(['status' => 'required|in:verified,rejected', 'catatan' => 'nullable|string']);
        $berkas->update([
            'status' => $request->status,
            'catatan' => $request->catatan,
            'verified_by' => auth()->id(),
            'verified_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Berkas '.$request->status.'.');
    }
}
