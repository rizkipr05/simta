@extends('layouts.app')
@section('title', 'Dashboard Dekan')
@section('breadcrumb', 'Dashboard Dekan')

@section('content')
<div class="space-y-6">
    <div class="bg-gradient-to-r from-emerald-900 via-teal-900 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl relative overflow-hidden border border-emerald-800/50">
        <div class="absolute -right-10 -bottom-10 w-60 h-60 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-500/20 text-emerald-300 rounded-full text-xs font-bold tracking-wide uppercase border border-emerald-500/30 mb-3">
                    <span class="w-2 h-2 rounded-full bg-yellow-400 animate-pulse"></span>
                    Pimpinan Fakultas Teknik UMMU
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Selamat Datang, Dekan</h1>
                <p class="text-slate-300 text-xs sm:text-sm mt-1 max-w-xl">
                    Persetujuan resmi Surat Keputusan (SK) Pembimbing &amp; Penguji Skripsi Mahasiswa Fakultas Teknik.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('dekan.approvals.index') }}" class="px-5 py-2.5 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs rounded-xl transition-all shadow-lg shadow-emerald-500/20 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Review SK Menunggu
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-all">
            <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-slate-500">SK Menunggu Approval</p>
            <div class="mt-3 flex items-center justify-between">
                <span class="text-3xl font-extrabold text-amber-600">{{ $stats['pending_sk'] ?? 0 }}</span>
                <span class="w-11 h-11 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
            </div>
            <p class="mt-2 text-[11px] text-amber-700 font-semibold">Perlu keputusan Dekan</p>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-all">
            <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-slate-500">SK Disetujui</p>
            <div class="mt-3 flex items-center justify-between">
                <span class="text-3xl font-extrabold text-emerald-600">{{ $stats['approved_sk'] ?? 0 }}</span>
                <span class="w-11 h-11 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </span>
            </div>
            <p class="mt-2 text-[11px] text-emerald-700 font-semibold">Sudah divalidasi</p>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-all">
            <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-slate-500">SK Ditolak</p>
            <div class="mt-3 flex items-center justify-between">
                <span class="text-3xl font-extrabold text-rose-600">{{ $stats['rejected_sk'] ?? 0 }}</span>
                <span class="w-11 h-11 rounded-2xl bg-rose-100 text-rose-700 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </span>
            </div>
            <p class="mt-2 text-[11px] text-rose-700 font-semibold">Perlu revisi dokumen</p>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-all">
            <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-slate-500">Dokumen Perlu Diperiksa</p>
            <div class="mt-3 flex items-center justify-between">
                <span class="text-3xl font-extrabold text-sky-600">{{ $stats['documents_to_review'] ?? 0 }}</span>
                <span class="w-11 h-11 rounded-2xl bg-sky-100 text-sky-700 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </span>
            </div>
            <p class="mt-2 text-[11px] text-sky-700 font-semibold">Jumlah dokumen review</p>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-[1.4fr_0.8fr] gap-6">
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="font-extrabold text-slate-900 text-base tracking-tight">SK Menunggu Persetujuan</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Daftar pengajuan SK pembimbing dan penguji yang memerlukan persetujuan Dekan</p>
                </div>
                <a href="{{ route('dekan.approvals.index') }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-900 flex items-center gap-1">
                    Kelola Semua
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            @if($pendingSkPembimbing->isNotEmpty() || $pendingSkPenguji->isNotEmpty())
                <div class="space-y-3">
                    @foreach($pendingSkPembimbing as $sk)
                        <div class="p-4 rounded-xl border border-amber-200 bg-amber-50/70 flex items-center justify-between gap-4">
                            <div>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="text-[10px] font-bold px-2 py-1 rounded-full bg-amber-100 text-amber-800 border border-amber-200">SK Pembimbing</span>
                                    <span class="text-xs text-slate-500 font-medium">{{ $sk->nomor_sk ?? 'Draft SK #' . $sk->id }}</span>
                                </div>
                                <p class="mt-1 text-sm font-bold text-slate-900">{{ $sk->skripsi?->mahasiswa?->nama ?? 'Mahasiswa' }}</p>
                                <p class="text-xs text-slate-500 mt-0.5">{{ $sk->skripsi?->judul ?? '-' }}</p>
                            </div>
                            <a href="{{ route('dekan.approvals.index') }}" class="px-3 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-[11px] font-bold rounded-xl">Review</a>
                        </div>
                    @endforeach

                    @foreach($pendingSkPenguji as $sk)
                        <div class="p-4 rounded-xl border border-sky-200 bg-sky-50/70 flex items-center justify-between gap-4">
                            <div>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="text-[10px] font-bold px-2 py-1 rounded-full bg-sky-100 text-sky-800 border border-sky-200">SK Penguji</span>
                                    <span class="text-xs text-slate-500 font-medium">{{ $sk->nomor_sk ?? 'Draft SK #' . $sk->id }}</span>
                                </div>
                                <p class="mt-1 text-sm font-bold text-slate-900">{{ $sk->ujian?->skripsi?->mahasiswa?->nama ?? 'Mahasiswa' }}</p>
                                <p class="text-xs text-slate-500 mt-0.5">{{ $sk->ujian?->skripsi?->judul ?? '-' }}</p>
                            </div>
                            <a href="{{ route('dekan.approvals.index') }}" class="px-3 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-[11px] font-bold rounded-xl">Review</a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-8 text-center bg-slate-50 rounded-xl border border-dashed border-slate-200">
                    <p class="text-xs text-slate-400 font-medium">Tidak ada SK yang menunggu persetujuan.</p>
                </div>
            @endif
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-5">
                <h2 class="font-extrabold text-slate-900 text-base tracking-tight">Aktivitas Approval Terbaru</h2>
            </div>

            @if($recentActivities->isNotEmpty())
                <div class="space-y-3">
                    @foreach($recentActivities as $activity)
                        <div class="flex items-start gap-3 rounded-xl border border-slate-200 bg-slate-50 p-3">
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center text-xs font-bold {{ $activity['status'] === 'Disetujui' ? 'bg-emerald-100 text-emerald-700' : ($activity['status'] === 'Ditolak' ? 'bg-rose-100 text-rose-700' : 'bg-amber-100 text-amber-700') }}">
                                @if($activity['status'] === 'Disetujui')
                                    ✓
                                @elseif($activity['status'] === 'Ditolak')
                                    ×
                                @else
                                    !
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-bold text-slate-900">{{ $activity['title'] }}</p>
                                <p class="text-[11px] text-slate-500 mt-1">{{ $activity['label'] }} · {{ $activity['description'] }}</p>
                                <p class="text-[10px] text-slate-400 mt-1">{{ \Carbon\Carbon::parse($activity['date'])->translatedFormat('d M Y') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-8 text-center bg-slate-50 rounded-xl border border-dashed border-slate-200">
                    <p class="text-xs text-slate-400 font-medium">Belum ada aktivitas approval.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection