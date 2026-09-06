<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Dokumen;
use App\Models\LembarPengesahan;
use App\Models\Mahasiswa;
use App\Models\Skripsi;
use Illuminate\Http\Request;

class UploadScanController extends Controller
{
    public function uploadPengesahan(Request $request, Skripsi $skripsi)
    {
        $request->validate([
            'file_pengesahan' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ], [
            'file_pengesahan.required' => 'Wajib memilih file untuk diunggah.',
            'file_pengesahan.file' => 'Dokumen yang diunggah tidak valid.',
            'file_pengesahan.mimes' => 'Format dokumen harus berupa PDF, JPG, atau PNG.',
            'file_pengesahan.max' => 'Ukuran dokumen maksimal adalah 10 MB.',
        ]);

        $path = $request->file('file_pengesahan')->store('pengesahan/scan', 'public');

        $pengesahan = LembarPengesahan::firstOrCreate(
            ['skripsi_id' => $skripsi->id],
            ['status' => 'diupload']
        );
        $pengesahan->update([
            'file_scan' => $path,
            'status' => 'diupload',
        ]);

        // Log the document
        Dokumen::create([
            'skripsi_id' => $skripsi->id,
            'jenis' => 'lembar_pengesahan_signed',
            'nama' => 'Scan Lembar Pengesahan - '.$skripsi->mahasiswa->nama,
            'file_path' => $path,
            'file_size' => $request->file('file_pengesahan')->getSize(),
            'status' => 'uploaded',
            'uploaded_by' => auth()->id(),
            'uploaded_at' => now(),
        ]);

        $skripsi->mahasiswa->update(['status_skripsi' => Mahasiswa::STATUS_PENGESAHAN_DIUPLOAD]);

        return redirect()->back()->with('success', 'Scan pengesahan berhasil diupload. Menunggu verifikasi pengelola.');
    }
}
