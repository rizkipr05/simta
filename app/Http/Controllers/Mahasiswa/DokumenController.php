<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Dokumen;
use App\Models\Mahasiswa;
use App\Models\Skripsi;
use Illuminate\Http\Request;

class DokumenController extends Controller
{
    public function index()
    {
        $mahasiswa = Mahasiswa::where('user_id', auth()->id())->firstOrFail();
        $skripsi = Skripsi::where('mahasiswa_id', $mahasiswa->id)->first();

        $dokumenList = [];
        if ($skripsi) {
            $dokumenList = Dokumen::where('skripsi_id', $skripsi->id)->latest()->get();
        }

        return view('mahasiswa.dokumen.index', compact('skripsi', 'dokumenList'));
    }

    public function store(Request $request)
    {
        $mahasiswa = Mahasiswa::where('user_id', auth()->id())->firstOrFail();
        $skripsi = Skripsi::where('mahasiswa_id', $mahasiswa->id)->firstOrFail();

        $request->validate([
            'jenis' => 'required|string',
            'nama' => 'required|string|max:255',
            'file_dokumen' => 'required|file|mimes:pdf,doc,docx|max:15360',
        ]);

        $file = $request->file('file_dokumen');
        $path = $file->store('dokumen_mahasiswa', 'public');

        Dokumen::create([
            'skripsi_id' => $skripsi->id,
            'jenis' => $request->jenis,
            'nama' => $request->nama,
            'file_path' => $path,
            'file_size' => $file->getSize(),
            'status' => 'uploaded',
            'uploaded_by' => auth()->id(),
            'uploaded_at' => now(),
        ]);

        return redirect()->route('mahasiswa.dokumen.index')->with('success', 'Dokumen berhasil diunggah.');
    }

    public function destroy(Dokumen $dokumen)
    {
        $mahasiswa = Mahasiswa::where('user_id', auth()->id())->firstOrFail();
        if ($dokumen->skripsi->mahasiswa_id !== $mahasiswa->id) {
            abort(403);
        }

        $dokumen->delete();

        return redirect()->back()->with('success', 'Dokumen berhasil dihapus.');
    }
}
