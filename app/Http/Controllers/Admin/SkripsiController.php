<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\Skripsi;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;

class SkripsiController extends Controller
{
    public function index(Request $request)
    {
        $skripsiList = Skripsi::with(['mahasiswa.prodi', 'tahunAkademik', 'pembimbing1.dosen', 'pembimbing2.dosen'])
            ->when($request->search, fn ($q) => $q->where('judul', 'like', "%{$request->search}%"))
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($request->tahun_akademik_id, fn ($q) => $q->where('tahun_akademik_id', $request->tahun_akademik_id))
            ->latest()->paginate(20)->withQueryString();
        $tahunList = TahunAkademik::all();
        $stats = [
            'total' => Skripsi::count(),
            'pengajuan' => Skripsi::where('status', 'pengajuan')->count(),
            'aktif' => Skripsi::where('status', 'aktif')->count(),
            'selesai' => Skripsi::where('status', 'selesai')->count(),
        ];

        return view('admin.skripsi.index', compact('skripsiList', 'tahunList', 'stats'));
    }

    public function show(Skripsi $skripsi)
    {
        $skripsi->load(['mahasiswa.prodi', 'tahunAkademik', 'pembimbing.dosen', 'skPembimbing', 'ujian.penguji.dosen', 'ujian.beritaAcara', 'lembarPengesahan', 'dokumen']);

        return view('admin.skripsi.show', compact('skripsi'));
    }

    public function edit(Skripsi $skripsi)
    {
        return view('admin.skripsi.edit', compact('skripsi'));
    }

    public function update(Request $request, Skripsi $skripsi)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:500',
            'deskripsi' => 'nullable|string',
            'bidang_kajian' => 'nullable|string|max:255',
        ]);
        $skripsi->update($validated);

        return redirect()->route('admin.skripsi.show', $skripsi)->with('success', 'Judul skripsi berhasil diperbarui.');
    }

    public function terima(Request $request, Skripsi $skripsi)
    {
        $skripsi->update([
            'status' => 'diterima',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);
        $skripsi->mahasiswa->update(['status_skripsi' => Mahasiswa::STATUS_PEMBIMBING_DITETAPKAN]);

        return redirect()->back()->with('success', 'Pengajuan skripsi diterima.');
    }

    public function tolak(Request $request, Skripsi $skripsi)
    {
        $request->validate(['catatan_penolakan' => 'required|string']);
        $skripsi->update([
            'status' => 'ditolak',
            'catatan_penolakan' => $request->catatan_penolakan,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);
        $skripsi->mahasiswa->update(['status_skripsi' => Mahasiswa::STATUS_BELUM_DAFTAR]);

        return redirect()->back()->with('success', 'Pengajuan skripsi ditolak.');
    }

    public function destroy(Skripsi $skripsi)
    {
        $skripsi->delete();

        return redirect()->route('admin.skripsi.index')->with('success', 'Data skripsi dihapus.');
    }
}
