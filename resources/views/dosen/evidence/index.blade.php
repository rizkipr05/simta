@extends('layouts.app')
@section('title', 'Evidence Locker')
@section('breadcrumb', 'Evidence Locker')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Evidence Locker</h1>
            <p class="text-xs text-slate-500 mt-1">Kelola berkas pendukung pembimbingan dan pengujian skripsi</p>
        </div>
        <div class="inline-flex items-center gap-2 rounded-full bg-indigo-100 text-indigo-800 px-3 py-1.5 text-xs font-bold border border-indigo-200">
            <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
            {{ $dokumenList->count() ?? 0 }} dokumen
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
        <form method="GET" action="{{ route('dosen.evidence.index') }}" class="flex flex-col sm:flex-row gap-3 mb-5">
            <div class="flex-1 relative">
                <input name="search" value="{{ request('search') }}" placeholder="Cari nama mahasiswa / dokumen..." class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all text-slate-800">
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <select name="status" class="px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 text-slate-800 font-medium">
                <option value="">Semua Status</option>
                <option value="uploaded" {{ request('status') == 'uploaded' ? 'selected' : '' }}>Uploaded</option>
                <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Verified</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
            <button type="submit" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white text-sm font-bold rounded-xl transition-all">Filter</button>
        </form>

        <div class="overflow-x-auto rounded-xl border border-slate-200">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-700">
                        <th class="text-left px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Dokumen</th>
                        <th class="text-left px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Mahasiswa</th>
                        <th class="text-left px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Jenis</th>
                        <th class="text-left px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Status</th>
                        <th class="text-left px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($dokumenList as $file)
                        <tr class="hover:bg-emerald-50/40 transition-colors">
                            <td class="px-4 py-3.5">
                                <p class="font-bold text-slate-900 text-sm leading-tight">{{ $file->nama ?? 'Dokumen' }}</p>
                                <p class="text-xs text-slate-500 mt-0.5">{{ $file->uploaded_at ? $file->uploaded_at->translatedFormat('d M Y') : '-' }}</p>
                            </td>
                            <td class="px-4 py-3.5 text-sm font-medium text-slate-700">
                                {{ $file->skripsi?->mahasiswa?->nama ?? '-' }}
                            </td>
                            <td class="px-4 py-3.5 text-sm text-slate-600">
                                {{ $file->jenis ?? 'Lainnya' }}
                            </td>
                            <td class="px-4 py-3.5">
                                <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold {{ $file->status === 'verified' ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : ($file->status === 'rejected' ? 'bg-rose-100 text-rose-800 border border-rose-200' : 'bg-amber-100 text-amber-800 border border-amber-200') }}">
                                    {{ $file->status ?? 'uploaded' }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5">
                                <a href="{{ route('dosen.evidence.download', $file->file_path ?? $file->id) }}" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-900 text-white text-[11px] font-bold rounded-lg transition-all shadow-sm">Download ↓</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-12 text-center text-slate-400 font-medium">Tidak ada data evidence ditemukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection