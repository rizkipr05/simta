<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\Pembimbing;
use App\Models\Skripsi;
use Illuminate\Http\Request;

class PembimbingController extends Controller
{
    public function store(Request $request, Skripsi $skripsi)
    {
        $request->validate([
            'dosen_id' => 'required|exists:dosen,id',
            'urutan' => 'required|in:1,2',
        ]);

        // Check if slot already taken
        if ($skripsi->pembimbing()->where('urutan', $request->urutan)->exists()) {
            return redirect()->back()->with('error', "Slot Pembimbing {$request->urutan} sudah terisi.");
        }

        Pembimbing::create([
            'skripsi_id' => $skripsi->id,
            'dosen_id' => $request->dosen_id,
            'urutan' => $request->urutan,
            'tanggal_disetujui' => now(),
            'status' => 'aktif',
        ]);

        // Advance state if at least 1 pembimbing
        if ($skripsi->pembimbing()->count() >= 1) {
            $skripsi->mahasiswa->update(['status_skripsi' => Mahasiswa::STATUS_PEMBIMBING_DITETAPKAN]);
            $skripsi->update(['status' => 'aktif']);
        }

        return redirect()->back()->with('success', "Pembimbing {$request->urutan} berhasil ditetapkan.");
    }

    public function destroy(Pembimbing $pembimbing)
    {
        $pembimbing->delete();

        return redirect()->back()->with('success', 'Pembimbing berhasil dihapus.');
    }
}
