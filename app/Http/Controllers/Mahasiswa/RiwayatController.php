<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $mahasiswa = $request->user()->mahasiswa;
        $skripsi = $mahasiswa?->skripsi;

        if ($skripsi) {
            $skripsi->load(['bimbingan', 'dokumen', 'pembimbing.dosen']);
        }

        return view('mahasiswa.riwayat.index', compact('mahasiswa', 'skripsi'));
    }
}
