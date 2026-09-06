<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Setting;
use App\Models\Skripsi;
use App\Models\Ujian;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class UjianController extends Controller
{
    public function index(Request $request)
    {
        $ujianList = Ujian::with(['skripsi.mahasiswa.prodi', 'penguji.dosen'])
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->latest('jadwal')->paginate(20)->withQueryString();

        return view('admin.ujian.index', compact('ujianList'));
    }

    public function create()
    {
        $skripsiList = Skripsi::whereIn('status', ['aktif'])->with('mahasiswa')->get();
        $dosenList = Dosen::where('is_aktif', true)->get();

        return view('admin.ujian.create', compact('skripsiList', 'dosenList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'skripsi_id' => 'required|exists:skripsi,id',
            'jadwal' => 'required|date',
            'tempat' => 'required|string|max:255',
            'ruangan' => 'nullable|string|max:100',
        ]);

        $ujian = Ujian::create(array_merge($validated, [
            'status' => 'dijadwalkan',
            'dijadwalkan_oleh' => auth()->id(),
        ]));

        $skripsi = Skripsi::find($request->skripsi_id);
        $skripsi->mahasiswa->update(['status_skripsi' => Mahasiswa::STATUS_UJIAN_DIJADWALKAN]);

        return redirect()->route('admin.ujian.show', $ujian)->with('success', 'Jadwal ujian berhasil dibuat.');
    }

    public function show(Ujian $ujian)
    {
        $ujian->load(['skripsi.mahasiswa.prodi', 'skripsi.pembimbing.dosen', 'penguji.dosen', 'beritaAcara', 'skPenguji']);
        $dosenList = Dosen::where('is_aktif', true)->get();

        return view('admin.ujian.show', compact('ujian', 'dosenList'));
    }

    public function edit(Ujian $ujian)
    {
        return view('admin.ujian.edit', compact('ujian'));
    }

    public function update(Request $request, Ujian $ujian)
    {
        $validated = $request->validate([
            'jadwal' => 'required|date',
            'tempat' => 'required|string|max:255',
            'ruangan' => 'nullable|string|max:100',
            'status' => 'required|in:dijadwalkan,berlangsung,selesai,ditunda',
        ]);
        $ujian->update($validated);

        return redirect()->route('admin.ujian.show', $ujian)->with('success', 'Jadwal ujian diperbarui.');
    }

    public function destroy(Ujian $ujian)
    {
        $ujian->delete();

        return redirect()->route('admin.ujian.index')->with('success', 'Jadwal ujian dihapus.');
    }

    public function undanganPdf(Ujian $ujian)
    {
        $ujian->load(['skripsi.mahasiswa.prodi', 'skripsi.pembimbing.dosen', 'penguji.dosen']);
        $settings = Setting::all()->pluck('value', 'key');
        $pdf = Pdf::loadView('pdf.undangan-ujian', compact('ujian', 'settings'))->setPaper('a4');

        return $pdf->download("Undangan_Ujian_{$ujian->skripsi->mahasiswa->nim}.pdf");
    }
}
