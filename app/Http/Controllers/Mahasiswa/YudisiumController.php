<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\BerkasYudisium;
use App\Models\Mahasiswa;
use App\Models\PendaftaranYudisium;
use App\Models\PeriodeYudisium;
use App\Models\PersyaratanYudisium;
use Illuminate\Http\Request;

class YudisiumController extends Controller
{
    public function index(Request $request)
    {
        $mahasiswa = $request->user()->mahasiswa;

        if (! $mahasiswa) {
            return view('mahasiswa.yudisium.index', [
                'mahasiswa' => null,
                'periodeAktif' => PeriodeYudisium::where('status', 'buka')->latest()->first(),
                'pendaftaran' => null,
                'persyaratanList' => PersyaratanYudisium::orderBy('urutan')->get(),
            ]);
        }

        $periodeAktif = PeriodeYudisium::where('status', 'buka')->latest()->first();
        $pendaftaran = $mahasiswa->pendaftaranYudisium()->with(['periode', 'berkas.persyaratan'])->latest()->first();
        $persyaratanList = PersyaratanYudisium::orderBy('urutan')->get();

        return view('mahasiswa.yudisium.index', compact('mahasiswa', 'periodeAktif', 'pendaftaran', 'persyaratanList'));
    }

    public function daftar(Request $request)
    {
        $mahasiswa = $request->user()->mahasiswa;
        $validated = $request->validate(['periode_id' => 'required|exists:periode_yudisium,id']);

        // Check eligibility
        $eligibleStatuses = [
            Mahasiswa::STATUS_PENGESAHAN_TERVERIFIKASI,
            Mahasiswa::STATUS_ADMINISTRASI_SELESAI,
            Mahasiswa::STATUS_ELIGIBLE_YUDISIUM,
        ];

        if (! in_array($mahasiswa->status_skripsi, $eligibleStatuses)) {
            return redirect()->back()->with('error', 'Anda belum eligible untuk mendaftar yudisium. Status: '.$mahasiswa->status_label);
        }

        if ($mahasiswa->pendaftaranYudisium()->where('periode_id', $validated['periode_id'])->exists()) {
            return redirect()->back()->with('error', 'Anda sudah terdaftar di periode ini.');
        }

        PendaftaranYudisium::create([
            'mahasiswa_id' => $mahasiswa->id,
            'periode_id' => $validated['periode_id'],
            'tanggal_daftar' => now()->toDateString(),
            'status' => 'daftar',
        ]);

        $mahasiswa->update(['status_skripsi' => Mahasiswa::STATUS_MENDAFTAR_YUDISIUM]);

        return redirect()->route('mahasiswa.yudisium.index')->with('success', 'Berhasil mendaftar yudisium! Silahkan upload berkas persyaratan.');
    }

    public function uploadBerkas(Request $request, PersyaratanYudisium $persyaratan)
    {
        $request->validate(['file' => 'required|file|max:10240']);
        $mahasiswa = $request->user()->mahasiswa;
        $pendaftaran = $mahasiswa->pendaftaranYudisium()->latest()->first();

        if (! $pendaftaran) {
            return redirect()->back()->with('error', 'Anda belum terdaftar yudisium.');
        }

        $path = $request->file('file')->store('yudisium/berkas', 'public');

        BerkasYudisium::updateOrCreate(
            ['pendaftaran_id' => $pendaftaran->id, 'persyaratan_id' => $persyaratan->id],
            [
                'file_path' => $path,
                'file_size' => $request->file('file')->getSize(),
                'status' => 'uploaded',
                'upload_by' => auth()->id(),
                'verified_by' => null,
                'verified_at' => null,
            ]
        );

        return redirect()->back()->with('success', "Berkas '{$persyaratan->nama_persyaratan}' berhasil diupload.");
    }
}
