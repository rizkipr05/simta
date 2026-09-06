@extends('layouts.app')
@section('title', 'Detail Mahasiswa Bimbingan')
@section('breadcrumb', 'Detail Mahasiswa Bimbingan')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between gap-3">
        <a href="{{ route('dosen.bimbingan.index') }}" class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-bold text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 rounded-xl transition shadow-sm w-fit">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar Mahasiswa
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">
            <div>
                <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Mahasiswa</p>
                <h1 class="mt-2 text-3xl font-extrabold text-slate-900 tracking-tight">{{ $bimbingan->skripsi?->mahasiswa?->nama ?? '-' }}</h1>
                <p class="text-sm font-medium text-slate-500 mt-1.5">NIM: {{ $bimbingan->skripsi?->mahasiswa?->nim ?? '-' }} <span class="mx-1.5 text-slate-300">•</span> Prodi: {{ $bimbingan->skripsi?->mahasiswa?->prodi?->nama ?? '-' }}</p>
            </div>
            <div class="inline-flex items-center gap-2 rounded-xl bg-emerald-50 px-4 py-2 text-xs font-bold text-emerald-800 border border-emerald-200 shadow-sm">
                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                {{ $bimbingan->skripsi?->status ?? 'Aktif' }}
            </div>
        </div>

        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
            <div class="rounded-xl border border-slate-200 bg-white shadow-sm p-5">
                <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-slate-500">Judul</p>
                <p class="mt-2 text-sm font-bold text-slate-900 line-clamp-2 leading-snug">{{ $bimbingan->skripsi?->judul ?? '-' }}</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white shadow-sm p-5">
                <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-slate-500">Progress</p>
                <p class="mt-2 text-2xl font-black text-emerald-600">{{ $progress }}%</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white shadow-sm p-5">
                <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-slate-500">Status Skripsi</p>
                <p class="mt-2 text-sm font-bold text-slate-900">{{ $bimbingan->skripsi?->mahasiswa?->status_label ?? '-' }}</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white shadow-sm p-5">
                <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-slate-500">Dokumen</p>
                <p class="mt-2 text-lg font-bold text-slate-900">{{ $bimbingan->skripsi?->dokumen?->count() ?? 0 }} berkas</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-[1.2fr_0.8fr] gap-6">
        <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm">
            <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
                <h2 class="text-lg font-extrabold text-slate-900">Riwayat Bimbingan</h2>
            </div>

            @if($consultations->isNotEmpty())
                <div class="space-y-4">
                    @foreach($consultations as $meeting)
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5 group hover:border-slate-300 transition-colors">
                            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-2">
                                <div>
                                    <p class="text-sm font-extrabold text-slate-900">{{ $meeting->topik }}</p>
                                    <p class="text-[11px] font-semibold text-slate-500 mt-1">{{ $meeting->tanggal_bimbingan?->translatedFormat('d M Y') ?? '-' }} · Bab: {{ $meeting->bab_bimbingan }}</p>
                                </div>
                                <span class="inline-flex px-3 py-1 rounded-full text-[10px] font-bold tracking-wide {{ $meeting->status === 'approved' ? 'bg-emerald-100 text-emerald-700' : ($meeting->status === 'revision' ? 'bg-rose-100 text-rose-700' : 'bg-amber-100 text-amber-700') }}">{{ ucfirst($meeting->status) }}</span>
                            </div>
                            <div class="mt-4 space-y-2">
                                <p class="text-sm text-slate-700"><span class="font-bold text-slate-900">Catatan mahasiswa:</span> {{ $meeting->catatan_mahasiswa ?? '-' }}</p>
                                <p class="text-sm text-slate-700"><span class="font-bold text-slate-900">Catatan dosen:</span> {{ $meeting->catatan_dosen ?? '-' }}</p>
                            </div>
                            <div class="mt-4 flex flex-wrap items-center gap-3">
                                @if($meeting->file_dokumen)
                                    <a href="{{ asset('storage/'.$meeting->file_dokumen) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-100/50 hover:bg-blue-100 text-blue-700 text-[11px] font-bold rounded-xl transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                        Bukti Bimbingan
                                    </a>
                                @endif
                                
                                <form method="POST" action="{{ route('dosen.bimbingan.respond', $meeting) }}" class="inline-block">
                                    @csrf
                                    <input type="hidden" name="status" value="approved">
                                    <input type="hidden" name="catatan_dosen" value="Disetujui oleh dosen pembimbing.">
                                    <button type="submit" class="inline-flex items-center gap-1 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-sm transition-all focus:ring-2 focus:ring-emerald-500 focus:ring-offset-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        Approve
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('dosen.bimbingan.respond', $meeting) }}" class="inline-flex items-center gap-2">
                                    @csrf
                                    <input type="hidden" name="status" value="revision">
                                    <input type="text" name="catatan_dosen" class="rounded-xl border border-slate-300 px-3 py-2 text-xs font-medium focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 outline-none w-48 transition-all" placeholder="Tulis revisi..." required>
                                    <button type="submit" class="inline-flex items-center gap-1 px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-xl shadow-sm transition-all focus:ring-2 focus:ring-rose-500 focus:ring-offset-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                        Revisi
                                    </button>
                                </form>

                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 p-10 text-center">
                    <p class="text-sm font-medium text-slate-500">Belum ada riwayat bimbingan untuk mahasiswa ini.</p>
                </div>
            @endif
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm self-start">
            <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
                <h2 class="text-lg font-extrabold text-slate-900">Catatan Revisi</h2>
            </div>
            @php $revisionEntries = $consultations->where('status', 'revision'); @endphp
            @if($revisionEntries->isNotEmpty())
                <div class="space-y-4">
                    @foreach($revisionEntries as $item)
                        <div class="rounded-xl border border-rose-200 bg-rose-50 p-4">
                            <p class="text-sm font-extrabold text-slate-900">{{ $item->bab_bimbingan }}</p>
                            <p class="text-xs font-medium text-slate-600 mt-1.5">{{ $item->catatan_dosen ?? 'Catatan revisi belum diisi.' }}</p>
                            <p class="text-[10px] font-bold text-slate-400 mt-3 uppercase tracking-wider">Status: {{ ucfirst($item->status) }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 p-8 text-center">
                    <p class="text-sm font-medium text-slate-500">Tidak ada catatan revisi saat ini.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection