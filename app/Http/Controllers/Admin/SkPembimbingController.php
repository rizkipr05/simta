<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\Setting;
use App\Models\SkPembimbing;
use App\Models\Skripsi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class SkPembimbingController extends Controller
{
    public function index()
    {
        $skList = SkPembimbing::with(['skripsi.mahasiswa.prodi', 'approvedBy'])
            ->latest()->paginate(20);

        return view('admin.sk-pembimbing.index', compact('skList'));
    }

    public function show(SkPembimbing $skPembimbing)
    {
        $skPembimbing->load(['skripsi.mahasiswa.prodi', 'skripsi.pembimbing.dosen', 'approvedBy']);

        return view('admin.sk-pembimbing.show', compact('skPembimbing'));
    }

    public function store(Request $request)
    {
        $request->validate(['skripsi_id' => 'required|exists:skripsi,id']);
        $skripsi = Skripsi::find($request->skripsi_id);
        SkPembimbing::create([
            'skripsi_id' => $skripsi->id,
            'status' => 'draft',
        ]);

        return redirect()->route('admin.sk-pembimbing.index')->with('success', 'Draft SK Pembimbing dibuat.');
    }

    public function generate(SkPembimbing $skPembimbing)
    {
        $nomorUrut = str_pad($skPembimbing->id, 3, '0', STR_PAD_LEFT);
        $bulan = now()->format('m');
        $tahun = now()->format('Y');
        $skPembimbing->update([
            'nomor_sk' => "SK.BIMB/{$nomorUrut}/{$bulan}/{$tahun}",
            'tanggal_sk' => now()->toDateString(),
            'status' => 'diajukan',
        ]);
        $skPembimbing->skripsi?->mahasiswa?->update(['status_skripsi' => Mahasiswa::STATUS_SK_PEMBIMBING_DISAHKAN]);

        return redirect()->back()->with('success', 'Nomor SK berhasil digenerate. SK telah diajukan ke Dekan.');
    }

    public function ajukan(SkPembimbing $skPembimbing)
    {
        $skPembimbing->update(['status' => 'diajukan']);

        return redirect()->back()->with('success', 'SK Pembimbing diajukan ke Dekan untuk persetujuan.');
    }

    public function pdf(SkPembimbing $skPembimbing)
    {
        $skPembimbing->load(['skripsi.mahasiswa.prodi', 'skripsi.pembimbing.dosen', 'approvedBy']);
        $settings = Setting::all()->pluck('value', 'key');
        $pdf = Pdf::loadView('pdf.sk-pembimbing', compact('skPembimbing', 'settings'))
            ->setPaper('a4');

        return $pdf->download("SK_Pembimbing_{$skPembimbing->skripsi->mahasiswa->nim}.pdf");
    }

    public function destroy(SkPembimbing $skPembimbing)
    {
        $skPembimbing->delete();

        return redirect()->route('admin.sk-pembimbing.index')->with('success', 'SK Pembimbing dihapus.');
    }
}
