@extends('layouts.app')
@section('title', 'Dashboard Dosen')
@section('breadcrumb', 'Dashboard Dosen')

@section('content')
<div class="space-y-6">
    <div class="bg-gradient-to-r from-emerald-900 via-teal-900 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl relative overflow-hidden border border-emerald-800/50">
        <div class="absolute -right-10 -bottom-10 w-60 h-60 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-500/20 text-emerald-300 rounded-full text-xs font-bold tracking-wide uppercase border border-emerald-500/30 mb-3">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Dosen Pembimbing &amp; Penguji FT UMMU
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Selamat Datang, {{ auth()->user()->name }}</h1>
                <p class="text-slate-300 text-xs sm:text-sm mt-1 max-w-xl">
                    Kelola mahasiswa bimbingan, persetujuan catatan revisi, jadwal sidang, dan penilaian skripsi secara terintegrasi.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('dosen.bimbingan.index') }}" class="px-5 py-2.5 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs rounded-xl transition-all shadow-lg shadow-emerald-500/20 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    Bimbingan Saya
                </a>
                <a href="{{ route('dosen.evidence.index') }}" class="px-5 py-2.5 bg-white/10 hover:bg-white/20 text-white font-bold text-xs rounded-xl transition-all border border-white/20 flex items-center gap-2">
                    <svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Evidence BKD
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-all">
            <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-slate-500">Jumlah Mahasiswa Bimbingan</p>
            <div class="mt-3 flex items-center justify-between">
                <span class="text-3xl font-extrabold text-emerald-600">{{ $stats['total_bimbingan'] ?? 0 }}</span>
                <span class="w-11 h-11 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </span>
            </div>
            <p class="mt-2 text-[11px] text-emerald-700 font-semibold">Mahasiswa aktif dalam pembimbingan</p>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-all">
            <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-slate-500">Bimbingan Menunggu Persetujuan</p>
            <div class="mt-3 flex items-center justify-between">
                <span class="text-3xl font-extrabold text-amber-600">{{ $stats['pending_bimbingan'] ?? 0 }}</span>
                <span class="w-11 h-11 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
            </div>
            <p class="mt-2 text-[11px] text-amber-700 font-semibold">Perlu review dosen</p>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-all">
            <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-slate-500">Revisi Mahasiswa</p>
            <div class="mt-3 flex items-center justify-between">
                <span class="text-3xl font-extrabold text-rose-600">{{ $stats['revisi_mahasiswa'] ?? 0 }}</span>
                <span class="w-11 h-11 rounded-2xl bg-rose-100 text-rose-700 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h5M20 20v-5h-5M20 9a8 8 0 00-13.4-5.4L4 9m16 6a8 8 0 01-13.4 5.4L4 15"/></svg>
                </span>
            </div>
            <p class="mt-2 text-[11px] text-rose-700 font-semibold">Dokumen butuh revisi</p>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-all">
            <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-slate-500">Jadwal Sidang</p>
            <div class="mt-3 flex items-center justify-between">
                <span class="text-3xl font-extrabold text-sky-600">{{ $stats['jadwal_sidang'] ?? 0 }}</span>
                <span class="w-11 h-11 rounded-2xl bg-sky-100 text-sky-700 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </span>
            </div>
            <p class="mt-2 text-[11px] text-sky-700 font-semibold">Tugas penguji aktif</p>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-all">
            <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-slate-500">Tugas Penilaian</p>
            <div class="mt-3 flex items-center justify-between">
                <span class="text-3xl font-extrabold text-violet-600">{{ $stats['tugas_penilaian'] ?? 0 }}</span>
                <span class="w-11 h-11 rounded-2xl bg-violet-100 text-violet-700 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </span>
            </div>
            <p class="mt-2 text-[11px] text-violet-700 font-semibold">Nilai sidang yang belum diinput</p>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-all">
            <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-slate-500">Aktivitas Terbaru</p>
            <div class="mt-3 flex items-center justify-between">
                <span class="text-3xl font-extrabold text-slate-700">{{ $recentActivities->count() }}</span>
                <span class="w-11 h-11 rounded-2xl bg-slate-100 text-slate-700 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z"/></svg>
                </span>
            </div>
            <p class="mt-2 text-[11px] text-slate-700 font-semibold">Log pembimbingan terakhir</p>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-[1.15fr_0.85fr] gap-6">
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="font-extrabold text-slate-900 text-base tracking-tight">Mahasiswa Bimbingan</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Daftar mahasiswa yang dibimbing serta status progress</p>
                </div>
                <a href="{{ route('dosen.bimbingan.index') }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-900 flex items-center gap-1">
                    Lihat Semua
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            @if($recentBimbingan->isNotEmpty())
                <div class="space-y-3">
                    @foreach($recentBimbingan as $item)
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                            <div class="flex items-center justify-between gap-3">
                                <div>
                                    <p class="text-sm font-bold text-slate-900">{{ $item->skripsi?->mahasiswa?->nama ?? '-' }}</p>
                                    <p class="text-[11px] text-slate-500">{{ $item->skripsi?->judul ?? '-' }}</p>
                                </div>
                                <span class="inline-flex px-2 py-1 rounded-full text-[10px] font-bold {{ $item->status === 'approved' ? 'bg-emerald-100 text-emerald-800' : ($item->status === 'revision' ? 'bg-rose-100 text-rose-700' : 'bg-amber-100 text-amber-800') }}">{{ ucfirst($item->status) }}</span>
                            </div>
                            <div class="mt-3 flex items-center justify-between text-[11px] text-slate-500">
                                <span>Progress: {{ min(100, 35 + ($item->skripsi?->bimbingan?->count() ?? 0) * 10) }}%</span>
                                <span>Revisi: {{ $item->skripsi?->bimbingan?->where('status', 'revision')->count() ?? 0 }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-8 text-center bg-slate-50 rounded-xl border border-dashed border-slate-200">
                    <p class="text-xs text-slate-400 font-medium">Belum ada mahasiswa bimbingan.</p>
                </div>
            @endif
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-5">
                <h2 class="font-extrabold text-slate-900 text-base tracking-tight">Aktivitas Terbaru</h2>
            </div>

            @if($recentActivities->isNotEmpty())
                <div class="space-y-3">
                    @foreach($recentActivities as $activity)
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                            <div class="flex items-start gap-3">
                                <div class="w-9 h-9 rounded-xl flex items-center justify-center text-xs font-bold {{ $activity['status'] === 'APPROVED' ? 'bg-emerald-100 text-emerald-700' : ($activity['status'] === 'REVISION' ? 'bg-rose-100 text-rose-700' : 'bg-amber-100 text-amber-700') }}">
                                    {{ $activity['status'][0] ?? '!' }}
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-bold text-slate-900">{{ $activity['title'] }}</p>
                                    <p class="text-[11px] text-slate-500 mt-1">{{ $activity['description'] }}</p>
                                    <p class="text-[10px] text-slate-400 mt-1">{{ \Carbon\Carbon::parse($activity['date'])->translatedFormat('d M Y') }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-8 text-center bg-slate-50 rounded-xl border border-dashed border-slate-200">
                    <p class="text-xs text-slate-400 font-medium">Belum ada aktivitas terbaru.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection