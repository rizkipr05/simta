@extends("layouts.app")
@section("title", "Dashboard Mahasiswa")
@section("breadcrumb", "Dashboard Mahasiswa")

@section("content")
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Dashboard Mahasiswa</h1>
            <p class="text-xs text-slate-500 mt-1">Selamat Datang, {{ $mahasiswa?->nama ?? auth()->user()->name }}! Pantau jalur skripsi Anda dari awal sampai yudisium.</p>
        </div>
        <a href="{{ route('mahasiswa.pengajuan.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-xl shadow-md shadow-emerald-600/20 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Ajukan / Kelola Skripsi
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
            <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Status Skripsi</p>
            <p class="mt-3 text-lg font-black text-emerald-700">{{ $skripsi ? str_replace('_', ' ', $skripsi->status) : 'Belum Ada' }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
            <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Judul</p>
            <p class="mt-3 text-sm font-extrabold text-slate-900 line-clamp-2">{{ $skripsi?->judul ?? 'Belum diusulkan' }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
            <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Pembimbing</p>
            <p class="mt-3 text-sm font-extrabold text-slate-900">{{ $skripsi?->pembimbing->pluck('dosen.nama_lengkap')->join(', ') ?: 'Belum ditetapkan' }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
            <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Progress</p>
            <p class="mt-3 text-lg font-black text-amber-600">{{ $skripsi ? 'On Track' : 'Belum Mulai' }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
        <a href="{{ route('mahasiswa.pengajuan.index') }}" class="group flex items-center gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm hover:shadow-md transition-all">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-teal-100 text-teal-700 group-hover:bg-teal-600 group-hover:text-white transition-all">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Pengajuan Judul</p>
                <p class="mt-1 text-sm font-extrabold text-slate-900 group-hover:text-teal-600 transition-colors">Kelola Judul</p>
            </div>
        </a>
        <a href="{{ route('mahasiswa.bimbingan.index') }}" class="group flex items-center gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm hover:shadow-md transition-all">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-blue-700 group-hover:bg-blue-600 group-hover:text-white transition-all">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Bimbingan</p>
                <p class="mt-1 text-sm font-extrabold text-slate-900 group-hover:text-blue-600 transition-colors">Ajukan &amp; Riwayat</p>
            </div>
        </a>
        <a href="{{ route('mahasiswa.dokumen.index') }}" class="group flex items-center gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm hover:shadow-md transition-all">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-100 text-indigo-700 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Dokumen</p>
                <p class="mt-1 text-sm font-extrabold text-slate-900 group-hover:text-indigo-600 transition-colors">Proposal &amp; Draft</p>
            </div>
        </a>
        <a href="{{ route('mahasiswa.yudisium.index') }}" class="group flex items-center gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm hover:shadow-md transition-all">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700 group-hover:bg-emerald-600 group-hover:text-white transition-all">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Yudisium</p>
                <p class="mt-1 text-sm font-extrabold text-slate-900 group-hover:text-emerald-600 transition-colors">Daftar &amp; Verifikasi</p>
            </div>
        </a>
        <a href="{{ route('mahasiswa.notifikasi.index') }}" class="group flex items-center gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm hover:shadow-md transition-all">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-100 text-amber-700 group-hover:bg-amber-600 group-hover:text-white transition-all">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 01-6 0v-1m6 0H9"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Notifikasi</p>
                <p class="mt-1 text-sm font-extrabold text-slate-900 group-hover:text-amber-600 transition-colors">Pemberitahuan</p>
            </div>
        </a>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <h2 class="text-lg font-extrabold text-slate-900">Ringkasan Aktivitas</h2>
            <div class="mt-4 space-y-3 text-sm">
                <div class="flex items-start justify-between gap-4 rounded-xl border border-slate-200 bg-slate-50 p-3">
                    <div>
                        <p class="font-bold text-slate-900">Bimbingan Terakhir</p>
                        <p class="text-slate-600">{{ optional($skripsi?->bimbingan()->latest('tanggal_bimbingan')->first())->topik ?? 'Belum ada jadwal bimbingan' }}</p>
                    </div>
                    <span class="text-xs font-bold text-slate-500">{{ optional($skripsi?->bimbingan()->latest('tanggal_bimbingan')->first())->tanggal_bimbingan?->format('d M Y') ?? '-' }}</span>
                </div>
                <div class="flex items-start justify-between gap-4 rounded-xl border border-slate-200 bg-slate-50 p-3">
                    <div>
                        <p class="font-bold text-slate-900">Revisi Aktif</p>
                        <p class="text-slate-600">{{ $skripsi?->catatan_penolakan ?? 'Tidak ada revisi aktif saat ini' }}</p>
                    </div>
                </div>
                <div class="flex items-start justify-between gap-4 rounded-xl border border-slate-200 bg-slate-50 p-3">
                    <div>
                        <p class="font-bold text-slate-900">Dokumen Terbaru</p>
                        <p class="text-slate-600">{{ optional($skripsi?->dokumen()->latest()->first())->nama ?? 'Belum ada dokumen diunggah' }}</p>
                    </div>
                    <span class="text-xs font-bold text-slate-500">{{ optional($skripsi?->dokumen()->latest()->first())->created_at?->format('d M Y') ?? '-' }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <h2 class="text-lg font-extrabold text-slate-900">Status Akademik</h2>
            <div class="mt-4 space-y-3 text-sm">
                <div class="flex items-center justify-between rounded-xl border border-slate-200 bg-slate-50 p-3">
                    <span class="font-bold text-slate-900">Jadwal Sidang</span>
                    <span class="text-slate-600">{{ optional($skripsi?->ujian)->tanggal_ujian ? optional($skripsi->ujian)->tanggal_ujian->format('d M Y') : 'Belum dijadwalkan' }}</span>
                </div>
                <div class="flex items-center justify-between rounded-xl border border-slate-200 bg-slate-50 p-3">
                    <span class="font-bold text-slate-900">Status Yudisium</span>
                    <span class="text-slate-600">{{ optional($mahasiswa?->pendaftaranYudisium()->latest()->first())->status ?? 'Belum mendaftar' }}</span>
                </div>
                <div class="flex items-center justify-between rounded-xl border border-slate-200 bg-slate-50 p-3">
                    <span class="font-bold text-slate-900">Notifikasi Baru</span>
                    <span class="text-slate-600">{{ $mahasiswa ? 'Tersedia' : 'Belum ada' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
