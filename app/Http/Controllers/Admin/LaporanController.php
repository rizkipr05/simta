<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\PendaftaranYudisium;
use App\Models\Skripsi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $stats = [
            'total_mahasiswa' => Mahasiswa::count(),
            'total_skripsi' => Skripsi::count(),
            'skripsi_aktif' => Skripsi::where('status', 'aktif')->count(),
            'skripsi_selesai' => Skripsi::where('status', 'selesai')->count(),
            'total_yudisium' => PendaftaranYudisium::count(),
            'yudisium_eligible' => PendaftaranYudisium::where('status', 'eligible')->count(),
        ];

        return view('admin.laporan.index', compact('stats'));
    }

    public function rekapSkripsi(Request $request)
    {
        $skripsiList = Skripsi::with(['mahasiswa.prodi', 'tahunAkademik'])
            ->when($request->tahun_akademik_id, fn ($q) => $q->where('tahun_akademik_id', $request->tahun_akademik_id))
            ->when($request->prodi_id, fn ($q) => $q->whereHas('mahasiswa', fn ($mq) => $mq->where('prodi_id', $request->prodi_id)))
            ->get();
        $pdf = Pdf::loadView('pdf.rekap-skripsi', compact('skripsiList'))->setPaper('a4', 'landscape');

        return $pdf->download('Rekap_Skripsi_'.now()->format('Y_m_d').'.pdf');
    }

    public function rekapYudisium(Request $request)
    {
        $pendaftaranList = PendaftaranYudisium::with(['mahasiswa.prodi', 'periode'])
            ->when($request->periode_id, fn ($q) => $q->where('periode_id', $request->periode_id))
            ->get();
        $pdf = Pdf::loadView('pdf.rekap-yudisium', compact('pendaftaranList'))->setPaper('a4', 'landscape');

        return $pdf->download('Rekap_Yudisium_'.now()->format('Y_m_d').'.pdf');
    }
}
