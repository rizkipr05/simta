<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penguji;
use App\Models\Ujian;
use Illuminate\Http\Request;

class PengujiController extends Controller
{
    public function store(Request $request, Ujian $ujian)
    {
        $request->validate([
            'dosen_id' => 'required|exists:dosen,id',
            'peran' => 'required|in:ketua,penguji_1,penguji_2',
        ]);

        if ($ujian->penguji()->where('peran', $request->peran)->exists()) {
            return redirect()->back()->with('error', "Slot {$request->peran} sudah terisi.");
        }

        Penguji::create([
            'ujian_id' => $ujian->id,
            'dosen_id' => $request->dosen_id,
            'peran' => $request->peran,
        ]);

        return redirect()->back()->with('success', 'Penguji berhasil ditambahkan.');
    }

    public function destroy(Penguji $penguji)
    {
        $penguji->delete();

        return redirect()->back()->with('success', 'Penguji dihapus.');
    }
}
