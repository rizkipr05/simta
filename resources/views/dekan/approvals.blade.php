@extends('layouts.app')
@section('title', 'Persetujuan SK')
@section('breadcrumb', 'Persetujuan SK')

@section('content')
<div class="space-y-6">
    <div class="bg-gradient-to-r from-emerald-900 via-teal-900 to-slate-900 rounded-3xl p-6 text-white shadow-xl border border-emerald-800/50">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-emerald-300">Review & Persetujuan</p>
                <h1 class="mt-2 text-2xl font-extrabold tracking-tight">Persetujuan SK</h1>
            </div>
            <div class="inline-flex items-center gap-2 rounded-full border border-emerald-500/30 bg-emerald-500/10 px-3 py-1.5 text-xs font-bold text-emerald-200">
                <span class="w-2 h-2 bg-yellow-400 rounded-full"></span>
                {{ ($skPembimbingList->total() + $skPengujiList->total()) }} dokumen menunggu review
            </div>
        </div>
    </div>

    <div class="space-y-6">
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="text-lg font-extrabold text-slate-900">Daftar SK Menunggu Persetujuan</h2>
                    <p class="text-xs text-slate-500 mt-1">Jenis SK, nomor, mahasiswa, prodi, tanggal pengajuan, preview, dan aksi persetujuan.</p>
                </div>
            </div>

            <div class="overflow-x-auto rounded-xl border border-slate-200 mt-4">
                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-700">
                        <tr>
                            <th class="px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Jenis & Nomor SK</th>
                            <th class="px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Informasi Mahasiswa</th>
                            <th class="px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Detail</th>
                            <th class="px-4 py-3.5 text-xs font-bold text-center uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @if($skPembimbingList->isNotEmpty())
                            @foreach($skPembimbingList as $sk)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-4 py-4 align-top">
                                        <span class="inline-flex px-2 py-0.5 rounded text-[10px] bg-amber-100 text-amber-800 font-bold mb-1">SK Pembimbing</span>
                                        <p class="font-bold font-mono text-xs text-slate-900">{{ $sk->nomor_sk ?? 'Draft SK #' . $sk->id }}</p>
                                        <p class="text-[11px] text-slate-500 mt-0.5">{{ $sk->created_at?->translatedFormat('d M Y') ?? '-' }}</p>
                                    </td>
                                    <td class="px-4 py-4 align-top">
                                        <p class="font-bold text-slate-800">{{ $sk->skripsi?->mahasiswa?->nama ?? '-' }}</p>
                                        <p class="text-[11px] text-slate-500 mb-1">{{ $sk->skripsi?->mahasiswa?->nim ?? '-' }} · {{ $sk->skripsi?->mahasiswa?->prodi?->nama ?? '-' }}</p>
                                        <p class="text-[11px] text-slate-600 line-clamp-1" title="{{ $sk->skripsi?->judul }}">{{ $sk->skripsi?->judul ?? '-' }}</p>
                                    </td>
                                    <td class="px-4 py-4 align-top">
                                        <p class="text-[11px] text-slate-600"><span class="font-bold text-slate-700">Pembimbing:</span><br>{{ $sk->skripsi?->pembimbing?->first()?->dosen?->nama ?? '-' }}</p>
                                        <a href="{{ route('dekan.sk-pembimbing.pdf', $sk) }}" target="_blank" class="inline-flex mt-2 items-center text-emerald-600 hover:text-emerald-800 font-bold text-[11px]">Preview PDF ↗</a>
                                    </td>
                                    <td class="px-4 py-4 align-top w-56">
                                        <div class="flex flex-col gap-2">
                                            <form method="POST" action="{{ route('dekan.approvals.sk-pembimbing.approve', $sk) }}" class="w-full">
                                                @csrf
                                                <button type="submit" class="w-full px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-[11px] font-bold rounded-lg transition-colors">Setujui</button>
                                            </form>
                                            <form method="POST" action="{{ route('dekan.approvals.sk-pembimbing.reject', $sk) }}" class="w-full">
                                                @csrf
                                                <div class="flex gap-1">
                                                    <input type="text" name="catatan" class="w-full min-w-0 rounded-lg border border-slate-300 px-2 py-1.5 text-[10px] focus:ring-2 focus:ring-rose-500" placeholder="Alasan tolak..." required>
                                                    <button type="submit" class="px-2 py-1.5 bg-rose-600 hover:bg-rose-700 text-white text-[11px] font-bold rounded-lg transition-colors">Tolak</button>
                                                </div>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                        @if($skPengujiList->isNotEmpty())
                            @foreach($skPengujiList as $sk)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-4 py-4 align-top">
                                        <span class="inline-flex px-2 py-0.5 rounded text-[10px] bg-sky-100 text-sky-800 font-bold mb-1">SK Penguji</span>
                                        <p class="font-bold font-mono text-xs text-slate-900">{{ $sk->nomor_sk ?? 'Draft SK #' . $sk->id }}</p>
                                        <p class="text-[11px] text-slate-500 mt-0.5">{{ $sk->created_at?->translatedFormat('d M Y') ?? '-' }}</p>
                                    </td>
                                    <td class="px-4 py-4 align-top">
                                        <p class="font-bold text-slate-800">{{ $sk->ujian?->skripsi?->mahasiswa?->nama ?? '-' }}</p>
                                        <p class="text-[11px] text-slate-500 mb-1">{{ $sk->ujian?->skripsi?->mahasiswa?->nim ?? '-' }} · {{ $sk->ujian?->skripsi?->mahasiswa?->prodi?->nama ?? '-' }}</p>
                                        <p class="text-[11px] text-slate-600">Jadwal Ujian: <span class="font-bold">{{ $sk->ujian?->jadwal?->translatedFormat('d M Y') ?? '-' }}</span></p>
                                    </td>
                                    <td class="px-4 py-4 align-top">
                                        <p class="text-[11px] text-slate-600"><span class="font-bold text-slate-700">Tim Penguji:</span><br>{{ $sk->ujian?->penguji?->pluck('dosen.nama')->implode(', ') ?: '-' }}</p>
                                        <a href="{{ route('dekan.sk-penguji.pdf', $sk) }}" target="_blank" class="inline-flex mt-2 items-center text-emerald-600 hover:text-emerald-800 font-bold text-[11px]">Preview PDF ↗</a>
                                    </td>
                                    <td class="px-4 py-4 align-top w-56">
                                        <div class="flex flex-col gap-2">
                                            <form method="POST" action="{{ route('dekan.approvals.sk-penguji.approve', $sk) }}" class="w-full">
                                                @csrf
                                                <button type="submit" class="w-full px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-[11px] font-bold rounded-lg transition-colors">Setujui</button>
                                            </form>
                                            <form method="POST" action="{{ route('dekan.approvals.sk-penguji.reject', $sk) }}" class="w-full">
                                                @csrf
                                                <div class="flex gap-1">
                                                    <input type="text" name="catatan" class="w-full min-w-0 rounded-lg border border-slate-300 px-2 py-1.5 text-[10px] focus:ring-2 focus:ring-rose-500" placeholder="Alasan tolak..." required>
                                                    <button type="submit" class="px-2 py-1.5 bg-rose-600 hover:bg-rose-700 text-white text-[11px] font-bold rounded-lg transition-colors">Tolak</button>
                                                </div>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                        @if($skPembimbingList->isEmpty() && $skPengujiList->isEmpty())
                            <tr>
                                <td colspan="4" class="px-4 py-12 text-center">
                                    <p class="text-sm text-slate-500">Tidak ada SK yang menunggu persetujuan saat ini.</p>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="text-lg font-extrabold text-slate-900">Riwayat Persetujuan</h2>
                    <p class="text-xs text-slate-500 mt-1">Daftar SK yang sudah diproses dan statusnya.</p>
                </div>
            </div>

            <div class="overflow-x-auto rounded-xl border border-slate-200 mt-4">
                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-700">
                        <tr>
                            <th class="px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Jenis & Nomor SK</th>
                            <th class="px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Mahasiswa</th>
                            <th class="px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Tgl Approval</th>
                            <th class="px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Catatan</th>
                            <th class="px-4 py-3.5 text-xs font-bold text-right uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @if($historySkPembimbingList->isNotEmpty() || $historySkPengujiList->isNotEmpty())
                            @foreach($historySkPembimbingList as $sk)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-4 py-3.5 font-bold font-mono text-xs text-slate-900 border-r border-slate-50">
                                        <span class="block text-[10px] text-slate-400 font-sans tracking-wide mb-0.5">SK PEMBIMBING</span>
                                        {{ $sk->nomor_sk ?? 'Draft SK #' . $sk->id }}
                                    </td>
                                    <td class="px-4 py-3.5 font-medium text-slate-800">{{ $sk->skripsi?->mahasiswa?->nama ?? '-' }}</td>
                                    <td class="px-4 py-3.5 text-slate-500 text-xs">{{ $sk->approved_at?->translatedFormat('d M Y') ?? '-' }}</td>
                                    <td class="px-4 py-3.5 text-slate-500 text-xs truncate max-w-[200px]" title="{{ $sk->catatan }}">{{ $sk->catatan ?: '-' }}</td>
                                    <td class="px-4 py-3.5 text-right">
                                        <span class="inline-flex px-2 py-1 rounded-full text-[10px] font-bold border {{ $sk->status === 'disetujui' ? 'bg-emerald-100 text-emerald-800 border-emerald-200' : 'bg-rose-100 text-rose-800 border-rose-200' }}">{{ $sk->status === 'disetujui' ? 'Disetujui' : 'Ditolak' }}</span>
                                    </td>
                                </tr>
                            @endforeach

                            @foreach($historySkPengujiList as $sk)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-4 py-3.5 font-bold font-mono text-xs text-slate-900 border-r border-slate-50">
                                        <span class="block text-[10px] text-slate-400 font-sans tracking-wide mb-0.5">SK PENGUJI</span>
                                        {{ $sk->nomor_sk ?? 'Draft SK #' . $sk->id }}
                                    </td>
                                    <td class="px-4 py-3.5 font-medium text-slate-800">{{ $sk->ujian?->skripsi?->mahasiswa?->nama ?? '-' }}</td>
                                    <td class="px-4 py-3.5 text-slate-500 text-xs">{{ $sk->approved_at?->translatedFormat('d M Y') ?? '-' }}</td>
                                    <td class="px-4 py-3.5 text-slate-500 text-xs truncate max-w-[200px]" title="{{ $sk->catatan }}">{{ $sk->catatan ?: '-' }}</td>
                                    <td class="px-4 py-3.5 text-right">
                                        <span class="inline-flex px-2 py-1 rounded-full text-[10px] font-bold border {{ $sk->status === 'disetujui' ? 'bg-emerald-100 text-emerald-800 border-emerald-200' : 'bg-rose-100 text-rose-800 border-rose-200' }}">{{ $sk->status === 'disetujui' ? 'Disetujui' : 'Ditolak' }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="px-4 py-12 text-center text-slate-400 font-medium">Belum ada riwayat approval.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection