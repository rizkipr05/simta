@extends("layouts.app")
@section("title", "Manajemen Skripsi")
@section("breadcrumb", "Manajemen Skripsi")

@section("content")
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Manajemen Skripsi</h1>
            <p class="text-xs text-slate-500 mt-1">Kelola pengajuan judul, penetapan pembimbing, dan alur status 17-State Skripsi</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
        <form method="GET" class="flex flex-col sm:flex-row gap-3 mb-5">
            <div class="flex-1 relative">
                <input name="search" value="{{ request('search') }}" placeholder="Cari Judul / Mahasiswa..." class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white text-slate-800">
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <select name="status" class="px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 text-slate-800 font-medium">
                <option value="">Semua Status</option>
                <option value="DRAFT" {{ request('status')=='DRAFT'?'selected':'' }}>Draft</option>
                <option value="PENGAJUAN_JUDUL" {{ request('status')=='PENGAJUAN_JUDUL'?'selected':'' }}>Pengajuan Judul</option>
                <option value="JUDUL_DISETUJUI" {{ request('status')=='JUDUL_DISETUJUI'?'selected':'' }}>Judul Disetujui</option>
                <option value="BIMBINGAN_PROPOSAL" {{ request('status')=='BIMBINGAN_PROPOSAL'?'selected':'' }}>Bimbingan Proposal</option>
                <option value="SELESAI" {{ request('status')=='SELESAI'?'selected':'' }}>Selesai</option>
            </select>
            <button type="submit" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white text-sm font-bold rounded-xl transition-all">Filter</button>
        </form>

        <div class="overflow-x-auto rounded-xl border border-slate-200">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-700">
                        <th class="text-left px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Mahasiswa</th>
                        <th class="text-left px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Judul Skripsi</th>
                        <th class="text-left px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Status State Engine</th>
                        <th class="text-left px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($skripsiList as $s)
                    <tr class="hover:bg-emerald-50/40 transition-colors">
                        <td class="px-4 py-3.5">
                            <p class="font-bold text-slate-900 leading-tight">{{ $s->mahasiswa?->nama }}</p>
                            <p class="text-xs text-slate-500 font-mono leading-tight mt-0.5">{{ $s->mahasiswa?->nim }}</p>
                        </td>
                        <td class="px-4 py-3.5 text-sm font-medium text-slate-700 max-w-md">
                            <p class="line-clamp-2">{{ $s->judul }}</p>
                        </td>
                        <td class="px-4 py-3.5">
                            <span class="status-badge bg-emerald-100 text-emerald-800 border border-emerald-200">{{ $s->status }}</span>
                        </td>
                        <td class="px-4 py-3.5">
                            <a href="{{ route('admin.skripsi.show', $s) }}" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-bold rounded-lg transition-all">Detail &amp; Alur</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-12 text-center text-slate-400 font-medium">Belum ada pengajuan skripsi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($skripsiList->hasPages())
        <div class="mt-4">{{ $skripsiList->links() }}</div>
        @endif
    </div>
</div>
@endsection
