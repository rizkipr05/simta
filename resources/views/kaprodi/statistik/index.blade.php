@extends('layouts.app')
@section('title', 'Statistik Prodi')
@section('breadcrumb', 'Statistik Prodi')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Statistik Prodi</h1>
            <p class="mt-1 text-xs text-slate-500">Ringkasan performa skripsi, bimbingan, dan kelulusan mahasiswa per program studi.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Total Mahasiswa</p>
            <p class="mt-3 text-3xl font-black text-slate-900">{{ $totalMahasiswa ?? 0 }}</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Total Skripsi</p>
            <p class="mt-3 text-3xl font-black text-slate-900">{{ $totalSkripsi ?? 0 }}</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Skripsi Aktif</p>
            <p class="mt-3 text-3xl font-black text-slate-900">{{ $skripsiAktif ?? 0 }}</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Rata-rata Lama Skripsi</p>
            <p class="mt-3 text-3xl font-black text-slate-900">{{ round($rataLama ?? 0) }} hari</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="text-lg font-extrabold text-slate-900">Statistik Bimbingan</h2>
            <div class="mt-4 space-y-3">
                <div class="rounded-xl bg-slate-50 p-3">
                    <p class="text-xs text-slate-500">Total Bimbingan</p>
                    <p class="mt-2 text-2xl font-black text-slate-900">{{ $bimbinganStats->total_bimbingan ?? 0 }}</p>
                </div>
                <div class="rounded-xl bg-slate-50 p-3">
                    <p class="text-xs text-slate-500">Mahasiswa Terlibat</p>
                    <p class="mt-2 text-2xl font-black text-slate-900">{{ $bimbinganStats->mahasiswa_terlibat ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="text-lg font-extrabold text-slate-900">Statistik Kelulusan</h2>
            <div class="mt-4 space-y-3">
                <div class="rounded-xl bg-slate-50 p-3">
                    <p class="text-xs text-slate-500">Skripsi Selesai</p>
                    <p class="mt-2 text-2xl font-black text-slate-900">{{ $skripsiSelesai ?? 0 }}</p>
                </div>
                <div class="rounded-xl bg-slate-50 p-3">
                    <p class="text-xs text-slate-500">Persentase Progress</p>
                    <p class="mt-2 text-2xl font-black text-slate-900">{{ $totalSkripsi ? round((($skripsiSelesai ?? 0) / $totalSkripsi) * 100) : 0 }}%</p>
                </div>
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <h2 class="text-lg font-extrabold text-slate-900">Per Program Studi</h2>
        <div class="mt-4 overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Prodi</th>
                        <th class="px-4 py-3 text-left text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Mahasiswa</th>
                        <th class="px-4 py-3 text-left text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Aktif</th>
                        <th class="px-4 py-3 text-left text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Selesai</th>
                        <th class="px-4 py-3 text-left text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Rata-rata Lama</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($prodiStats as $stat)
                        <tr>
                            <td class="px-4 py-3 font-bold text-slate-900">{{ $stat['prodi'] }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $stat['total_mahasiswa'] }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $stat['skripsi_aktif'] }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $stat['skripsi_selesai'] }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ round($stat['rata_lama'] ?? 0) }} hari</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-sm text-slate-500">Belum ada data prodi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
