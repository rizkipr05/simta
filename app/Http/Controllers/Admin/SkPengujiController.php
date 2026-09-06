<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\SkPenguji;
use App\Models\Ujian;
use Barryvdh\DomPDF\Facade\Pdf;

class SkPengujiController extends Controller
{
    public function generate(Ujian $ujian)
    {
        $nomorUrut = str_pad($ujian->id, 3, '0', STR_PAD_LEFT);
        $bulan = now()->format('m');
        $tahun = now()->format('Y');

        $skPenguji = SkPenguji::updateOrCreate(['ujian_id' => $ujian->id], [
            'nomor_sk' => "SK.PENGUJI/{$nomorUrut}/{$bulan}/{$tahun}",
            'tanggal_sk' => now()->toDateString(),
            'status' => 'diajukan',
        ]);

        return redirect()->back()->with('success', 'SK Penguji berhasil digenerate.');
    }

    public function pdf(SkPenguji $skPenguji)
    {
        $skPenguji->load(['ujian.skripsi.mahasiswa.prodi', 'ujian.penguji.dosen', 'approvedBy']);
        $settings = Setting::all()->pluck('value', 'key');
        $pdf = Pdf::loadView('pdf.sk-penguji', compact('skPenguji', 'settings'))->setPaper('a4');
        $nim = $skPenguji->ujian->skripsi->mahasiswa->nim;

        return $pdf->download("SK_Penguji_{$nim}.pdf");
    }
}
