<?php

namespace App\Http\Controllers\Kaprodi;

use App\Http\Controllers\Controller;
use App\Models\Bimbingan;
use App\Models\Mahasiswa;
use App\Models\PendaftaranYudisium;
use App\Models\Skripsi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    public function index(Request $request)
    {
        $mahasiswaList = Mahasiswa::with(['prodi', 'skripsi.pembimbing.dosen', 'skripsi.bimbingan'])
            ->when($request->search, fn ($q) => $q->where('nama', 'like', "%{$request->search}%")->orWhere('nim', 'like', "%{$request->search}%"))
            ->when($request->status, fn ($q) => $q->where('status_skripsi', $request->status))
            ->orderBy('nama')
            ->paginate(20)
            ->withQueryString();

        foreach ($mahasiswaList as $mahasiswa) {
            $mahasiswa->progress = $this->calculateProgress($mahasiswa);
            $mahasiswa->bimbingan_count = $mahasiswa->skripsi?->bimbingan()->count() ?? 0;
            $mahasiswa->revisi_count = $mahasiswa->skripsi?->bimbingan()->where('status', 'revisi')->count() ?? 0;
            $mahasiswa->days_since_start = $mahasiswa->skripsi && $mahasiswa->skripsi->tanggal_mulai
                ? (int) Carbon::parse($mahasiswa->skripsi->tanggal_mulai)->diffInDays(now())
                : 0;
        }

        return view('kaprodi.monitoring.index', compact('mahasiswaList'));
    }

    public function show(Mahasiswa $mahasiswa)
    {
        $mahasiswa->load([
            'prodi',
            'skripsi.pembimbing.dosen',
            'skripsi.ujian.penguji.dosen',
            'skripsi.bimbingan.dosen',
            'skripsi.beritaAcara',
            'skripsi.lembarPengesahan',
            'pendaftaranYudisium.periode',
        ]);

        $mahasiswa->progress = $this->calculateProgress($mahasiswa);
        $mahasiswa->bimbingan_count = $mahasiswa->skripsi?->bimbingan()->count() ?? 0;
        $mahasiswa->revisi_count = $mahasiswa->skripsi?->bimbingan()->where('status', 'revisi')->count() ?? 0;
        $mahasiswa->days_since_start = $mahasiswa->skripsi && $mahasiswa->skripsi->tanggal_mulai
            ? (int) Carbon::parse($mahasiswa->skripsi->tanggal_mulai)->diffInDays(now())
            : 0;

        return view('kaprodi.monitoring.show', compact('mahasiswa'));
    }

    public function yudisium(Request $request)
    {
        $yudisiumList = PendaftaranYudisium::with(['mahasiswa.prodi', 'mahasiswa.skripsi', 'periode'])
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->orderBy('tanggal_daftar', 'desc')
            ->paginate(20)
            ->withQueryString();

        foreach ($yudisiumList as $item) {
            $item->dokumen_terlengkap = $item->berkas()->count() >= 3;
            $item->status_verifikasi = $item->status === 'verified' ? 'Terverifikasi' : ($item->status === 'pending' ? 'Menunggu' : 'Ditolak');
            $item->ipk = $item->mahasiswa?->ipk ?? 0;
        }

        return view('kaprodi.monitoring.yudisium', compact('yudisiumList'));
    }

    public function statistik()
    {
        $totalMahasiswa = Mahasiswa::count();
        $totalSkripsi = Skripsi::count();
        $skripsiAktif = Skripsi::where('status', 'aktif')->count();
        $skripsiSelesai = Skripsi::where('status', 'selesai')->count();
        $rataLama = Skripsi::whereNotNull('tanggal_mulai')->get()->avg(function ($skripsi) {
            return $skripsi->tanggal_mulai ? $skripsi->tanggal_mulai->diffInDays(now()) : 0;
        });

        $bimbinganStats = Bimbingan::selectRaw('COUNT(*) as total_bimbingan, COUNT(DISTINCT mahasiswa_id) as mahasiswa_terlibat')
            ->first();

        $prodiStats = Mahasiswa::with('prodi', 'skripsi')
            ->get()
            ->groupBy('prodi_id')
            ->map(function ($items) {
                $skripsi = $items->filter(fn ($item) => $item->skripsi !== null);

                return [
                    'prodi' => $items->first()->prodi?->nama ?? 'Prodi Tidak Diketahui',
                    'total_mahasiswa' => $items->count(),
                    'skripsi_aktif' => $skripsi->filter(fn ($item) => $item->skripsi->status === 'aktif')->count(),
                    'skripsi_selesai' => $skripsi->filter(fn ($item) => $item->skripsi->status === 'selesai')->count(),
                    'rata_lama' => $skripsi->avg(fn ($item) => $item->skripsi && $item->skripsi->tanggal_mulai ? $item->skripsi->tanggal_mulai->diffInDays(now()) : 0),
                    'beban_pembimbing' => $items->count(),
                ];
            })
            ->values();

        return view('kaprodi.statistik.index', compact(
            'totalMahasiswa',
            'totalSkripsi',
            'skripsiAktif',
            'skripsiSelesai',
            'rataLama',
            'bimbinganStats',
            'prodiStats'
        ));
    }

    protected function calculateProgress(Mahasiswa $mahasiswa): int
    {
        if (! $mahasiswa->skripsi) {
            return 0;
        }

        $statusProgress = [
            'pengajuan' => 15,
            'aktif' => 45,
            'selesai' => 100,
            'ditolak' => 0,
        ];

        return $statusProgress[$mahasiswa->skripsi->status] ?? 20;
    }
}
