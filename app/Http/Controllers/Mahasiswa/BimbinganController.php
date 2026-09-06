<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Bimbingan;
use App\Models\Mahasiswa;
use App\Models\Skripsi;
use Illuminate\Http\Request;

class BimbinganController extends Controller
{
    public function index()
    {
        $mahasiswa = Mahasiswa::where('user_id', auth()->id())->firstOrFail();
        $skripsi = Skripsi::where('mahasiswa_id', $mahasiswa->id)->with('pembimbing.dosen')->first();

        $bimbinganList = [];
        if ($skripsi) {
            $bimbinganList = Bimbingan::where('skripsi_id', $skripsi->id)
                ->with('dosen')
                ->latest()
                ->paginate(10);
        }

        return view('mahasiswa.bimbingan.index', compact('skripsi', 'bimbinganList'));
    }

    public function create()
    {
        $mahasiswa = Mahasiswa::where('user_id', auth()->id())->firstOrFail();
        $skripsi = Skripsi::where('mahasiswa_id', $mahasiswa->id)->with('pembimbing.dosen')->first();

        return view('mahasiswa.bimbingan.create', compact('skripsi'));
    }

    public function store(Request $request)
    {
        $mahasiswa = Mahasiswa::where('user_id', auth()->id())->firstOrFail();
        $skripsi = Skripsi::where('mahasiswa_id', $mahasiswa->id)->firstOrFail();

        $request->validate([
            'dosen_id' => 'required|exists:dosen,id',
            'bab_bimbingan' => 'required|string|max:100',
            'topik' => 'required|string|max:255',
            'catatan_mahasiswa' => 'required|string',
            'tanggal_bimbingan' => 'nullable|date',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $filePath = null;
        if ($request->hasFile('file_dokumen')) {
            $filePath = $request->file('file_dokumen')->store('bimbingan_files', 'public');
        }

        Bimbingan::create([
            'skripsi_id' => $skripsi->id,
            'dosen_id' => $request->dosen_id,
            'mahasiswa_id' => $mahasiswa->id,
            'bab_bimbingan' => $request->bab_bimbingan,
            'topik' => $request->topik,
            'catatan_mahasiswa' => $request->catatan_mahasiswa,
            'file_dokumen' => $filePath,
            'status' => 'pending',
            'tanggal_bimbingan' => $request->tanggal_bimbingan ? $request->tanggal_bimbingan : now(),
        ]);

        return redirect()->route('mahasiswa.bimbingan.index')->with('success', 'Pengajuan bimbingan berhasil dikirim.');
    }

    public function destroy(Bimbingan $bimbingan)
    {
        $mahasiswa = Mahasiswa::where('user_id', auth()->id())->firstOrFail();
        if ($bimbingan->mahasiswa_id !== $mahasiswa->id) {
            abort(403);
        }

        if ($bimbingan->status !== 'pending') {
            return redirect()->back()->with('error', 'Bimbingan yang sudah direspons dosen tidak dapat dihapus.');
        }

        $bimbingan->delete();

        return redirect()->back()->with('success', 'Pengajuan bimbingan berhasil dibatalkan/dihapus.');
    }
}
