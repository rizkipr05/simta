<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PengesahanController extends Controller
{
    public function index(Request $request)
    {
        $mahasiswa = $request->user()->mahasiswa;
        if (! $mahasiswa) {
            return view('mahasiswa.pengesahan.index', ['mahasiswa' => null, 'skripsi' => null]);
        }

        $skripsi = $mahasiswa->skripsi()->with('lembarPengesahan')->first();

        return view('mahasiswa.pengesahan.index', compact('mahasiswa', 'skripsi'));
    }

    public function store(Request $request, \App\Models\Skripsi $skripsi)
    {
        $request->validate([
            'file_pengesahan' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ], [
            'file_pengesahan.required' => 'Wajib memilih file untuk diunggah.',
            'file_pengesahan.file' => 'Dokumen yang diunggah tidak valid.',
            'file_pengesahan.mimes' => 'Format dokumen harus berupa PDF, JPG, atau PNG.',
            'file_pengesahan.max' => 'Ukuran dokumen maksimal adalah 10 MB.',
        ]);

        if ($skripsi->mahasiswa_id !== $request->user()->mahasiswa->id) {
            abort(403);
        }

        $path = $request->file('file_pengesahan')->store('lembar_pengesahan', 'public');

        $skripsi->lembarPengesahan()->updateOrCreate(
            ['skripsi_id' => $skripsi->id],
            [
                'file_scan' => $path,
                'status' => 'menunggu_verifikasi',
            ]
        );

        return redirect()->back()->with('success', 'Berhasil mengunggah dokumen lembar pengesahan.');
    }
}
