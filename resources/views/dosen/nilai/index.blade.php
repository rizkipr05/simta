@extends('layouts.app')
@section('title', 'Input Nilai Ujian')
@section('breadcrumb', 'Input Nilai Ujian')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Input Nilai Ujian</h1>
            <p class="text-xs text-slate-500 mt-1">Kelola penilaian sidang skripsi mahasiswa yang Anda ujikan</p>
        </div>
        <div class="inline-flex items-center gap-2 rounded-full bg-sky-100 text-sky-800 px-3 py-1.5 text-xs font-bold border border-sky-200">
            <span class="w-2 h-2 rounded-full bg-sky-500"></span>
            {{ $pengujianList->count() ?? 0 }} ujian
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
        <form method="GET" class="flex flex-col sm:flex-row gap-3 mb-5">
            <div class="flex-1 relative">
                <input name="search" value="{{ request('search') }}" placeholder="Cari NIM / Nama Mahasiswa..." class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all text-slate-800">
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <select name="status" class="px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 text-slate-800 font-medium">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
            <button type="submit" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white text-sm font-bold rounded-xl transition-all">Filter</button>
        </form>

        <div class="overflow-x-auto rounded-xl border border-slate-200">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-700">
                        <th class="text-left px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Mahasiswa</th>
                        <th class="text-left px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Judul</th>
                        <th class="text-left px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Jadwal</th>
                        <th class="text-left px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Nilai</th>
                        <th class="text-left px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Status</th>
                        <th class="text-left px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($pengujianList as $item)
                        @php
                            $ujian = $item->ujian;
                            $mahasiswa = $ujian?->skripsi?->mahasiswa;
                            $judul = $ujian?->skripsi?->judul ?? '-';
                        @endphp
                        <tr class="hover:bg-emerald-50/40 transition-colors">
                            <td class="px-4 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-sky-500 to-emerald-600 text-white flex items-center justify-center font-bold text-xs">{{ strtoupper(substr($mahasiswa?->nama ?? 'M', 0, 2)) }}</div>
                                    <div>
                                        <p class="font-bold text-slate-900 text-sm leading-tight">{{ $mahasiswa?->nama ?? '-' }}</p>
                                        <p class="text-xs text-slate-500 font-mono leading-tight mt-0.5">{{ $mahasiswa?->nim ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3.5 text-sm font-medium text-slate-700 max-w-md">
                                <span class="line-clamp-2">{{ $judul }}</span>
                            </td>
                            <td class="px-4 py-3.5 text-sm text-slate-600">
                                {{ $ujian?->jadwal ? \Carbon\Carbon::parse($ujian->jadwal)->translatedFormat('d M Y · H:i') : '-' }}
                            </td>
                            <td class="px-4 py-3.5">
                                <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold {{ !is_null($item->nilai) ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : 'bg-amber-100 text-amber-800 border border-amber-200' }}">
                                    {{ $item->nilai?->nilai_total ?? 'Belum ada' }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5">
                                <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold {{ $item->status === 'selesai' ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : 'bg-sky-100 text-sky-800 border border-sky-200' }}">
                                    {{ $item->status ?? 'Pending' }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5">
                                <a href="{{ route('dosen.nilai.show', $item->id) }}" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-lg transition-all">
                                    {{ !is_null($item->nilai) ? 'Edit' : 'Input' }}
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center text-slate-400 font-medium">Tidak ada data penilaian ditemukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection