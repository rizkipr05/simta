<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BeritaAcara;
use App\Models\Mahasiswa;
use App\Models\Setting;
use App\Models\Ujian;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class BeritaAcaraController extends Controller
{
    public function index()
    {
        $baList = BeritaAcara::with(['ujian.skripsi.mahasiswa'])->latest()->paginate(20);

        return view('admin.berita-acara.index', compact('baList'));
    }

    public function create()
    {
        $ujianList = Ujian::where('status', 'selesai')->doesntHave('beritaAcara')->with('skripsi.mahasiswa')->get();

        return view('admin.berita-acara.create', compact('ujianList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ujian_id' => 'required|exists:ujian,id',
            'keputusan' => 'required|in:lulus,mengulang,tidak_lulus',
            'rekomendasi' => 'nullable|string',
        ]);

        $ujian = Ujian::with('nilaiUjian')->find($request->ujian_id);
        $nilaiRata = $ujian->nilaiUjian->avg('nilai_total') ?? 0;
        $predikat = $this->hitungPredikat($nilaiRata);

        BeritaAcara::create(array_merge($validated, [
            'nilai_akhir' => $nilaiRata,
            'predikat' => $predikat,
            'status' => 'draft',
        ]));

        return redirect()->route('admin.berita-acara.index')->with('success', 'Berita Acara berhasil dibuat.');
    }

    public function show(BeritaAcara $beritaAcara)
    {
        $beritaAcara->load(['ujian.skripsi.mahasiswa.prodi', 'ujian.penguji.dosen', 'ujian.nilaiUjian.penguji.dosen']);

        return view('admin.berita-acara.show', compact('beritaAcara'));
    }

    public function edit(BeritaAcara $beritaAcara)
    {
        return view('admin.berita-acara.edit', compact('beritaAcara'));
    }

    public function update(Request $request, BeritaAcara $beritaAcara)
    {
        $validated = $request->validate([
            'keputusan' => 'required|in:lulus,mengulang,tidak_lulus',
            'rekomendasi' => 'nullable|string',
        ]);
        $beritaAcara->update($validated);

        return redirect()->route('admin.berita-acara.show', $beritaAcara)->with('success', 'Berita Acara diperbarui.');
    }

    public function destroy(BeritaAcara $beritaAcara)
    {
        $beritaAcara->delete();

        return redirect()->route('admin.berita-acara.index')->with('success', 'Berita Acara dihapus.');
    }

    public function generate(BeritaAcara $beritaAcara)
    {
        $nomorUrut = str_pad($beritaAcara->id, 3, '0', STR_PAD_LEFT);
        $beritaAcara->update([
            'nomor_ba' => "BA.UJIAN/{$nomorUrut}/".now()->format('m/Y'),
            'status' => 'final',
        ]);
        $beritaAcara->ujian?->skripsi?->mahasiswa?->update(['status_skripsi' => Mahasiswa::STATUS_BA_FINAL]);

        return redirect()->back()->with('success', 'BA berhasil di-generate dan difinalkan.');
    }

    public function finalize(BeritaAcara $beritaAcara)
    {
        $beritaAcara->update(['status' => 'verified', 'approved_by' => auth()->id(), 'approved_at' => now()]);
        $beritaAcara->ujian?->skripsi?->mahasiswa?->update(['status_skripsi' => Mahasiswa::STATUS_MENUNGGU_PENGESAHAN]);

        return redirect()->back()->with('success', 'BA finalized. Mahasiswa diarahkan ke pengesahan.');
    }

    public function pdf(BeritaAcara $beritaAcara)
    {
        $beritaAcara->load(['ujian.skripsi.mahasiswa.prodi', 'ujian.penguji.dosen', 'ujian.nilaiUjian.penguji.dosen']);
        $settings = Setting::all()->pluck('value', 'key');
        $pdf = Pdf::loadView('pdf.berita-acara', compact('beritaAcara', 'settings'))->setPaper('a4');
        $nim = $beritaAcara->ujian?->skripsi?->mahasiswa?->nim ?? 'export';

        return $pdf->download("Berita_Acara_{$nim}.pdf");
    }

    private function hitungPredikat(float $nilai): string
    {
        if ($nilai >= 90) {
            return 'A';
        }
        if ($nilai >= 80) {
            return 'AB';
        }
        if ($nilai >= 70) {
            return 'B';
        }
        if ($nilai >= 60) {
            return 'BC';
        }
        if ($nilai >= 50) {
            return 'C';
        }
        if ($nilai >= 40) {
            return 'D';
        }

        return 'E';
    }
}
