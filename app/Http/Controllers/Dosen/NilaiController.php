<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\NilaiUjian;
use App\Models\Penguji;
use App\Models\Ujian;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function index(Request $request)
    {
        $dosen = $request->user()->dosen;
        $pengujianList = $dosen->pengujian()->with(['ujian.skripsi.mahasiswa', 'nilai'])->paginate(15);

        return view('dosen.nilai.index', compact('pengujianList'));
    }

    public function show(Penguji $penguji)
    {
        $penguji->load(['ujian.skripsi.mahasiswa.prodi', 'nilai']);

        return view('dosen.nilai.show', compact('penguji'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'penguji_id' => 'required|exists:penguji,id',
            'nilai_penguasaan_materi' => 'required|numeric|min:0|max:100',
            'nilai_kemampuan_presentasi' => 'required|numeric|min:0|max:100',
            'nilai_penulisan' => 'required|numeric|min:0|max:100',
            'catatan' => 'nullable|string',
        ]);

        $total = ($validated['nilai_penguasaan_materi'] + $validated['nilai_kemampuan_presentasi'] + $validated['nilai_penulisan']) / 3;
        $validated['nilai_total'] = round($total, 2);
        $validated['ujian_id'] = Penguji::find($validated['penguji_id'])->ujian_id;

        NilaiUjian::updateOrCreate(
            ['ujian_id' => $validated['ujian_id'], 'penguji_id' => $validated['penguji_id']],
            $validated
        );

        // Check if all penguji have inputted nilai
        $ujian = Ujian::find($validated['ujian_id']);
        $allNilaiDone = $ujian->penguji->count() > 0 && $ujian->penguji->every(fn ($p) => $p->nilai !== null);
        if ($allNilaiDone) {
            $ujian->update(['status' => 'selesai']);
            $ujian->skripsi->mahasiswa->update(['status_skripsi' => Mahasiswa::STATUS_UJIAN_SELESAI]);
        }

        return redirect()->back()->with('success', 'Nilai berhasil disimpan.');
    }

    public function update(Request $request, NilaiUjian $nilai)
    {
        $validated = $request->validate([
            'nilai_penguasaan_materi' => 'required|numeric|min:0|max:100',
            'nilai_kemampuan_presentasi' => 'required|numeric|min:0|max:100',
            'nilai_penulisan' => 'required|numeric|min:0|max:100',
            'catatan' => 'nullable|string',
        ]);
        $total = ($validated['nilai_penguasaan_materi'] + $validated['nilai_kemampuan_presentasi'] + $validated['nilai_penulisan']) / 3;
        $validated['nilai_total'] = round($total, 2);
        $nilai->update($validated);

        return redirect()->back()->with('success', 'Nilai diperbarui.');
    }
}
