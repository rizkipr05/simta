<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $mahasiswa = $user->mahasiswa?->load(['prodi', 'skripsi.pembimbing.dosen', 'skripsi.ujian', 'skripsi.lembarPengesahan', 'pendaftaranYudisium.periode']);
        $skripsi = $mahasiswa?->skripsi;

        return view('mahasiswa.dashboard', compact('mahasiswa', 'skripsi'));
    }
}
