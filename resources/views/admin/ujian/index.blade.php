@extends("layouts.app")
@section("title", "Ujian Skripsi")
@section("breadcrumb", "Ujian Skripsi")

@section("content")
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Jadwal Ujian Skripsi</h1>
            <p class="text-xs text-slate-500 mt-1">Penjadwalan Seminar Proposal, Ujian Hasil, dan Sidang Munaqasyah</p>
        </div>
        <a href="{{ route('admin.ujian.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-xl shadow-md shadow-emerald-600/20 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Buat Jadwal Ujian
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
        <div class="overflow-x-auto rounded-xl border border-slate-200">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-700">
                        <th class="text-left px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Mahasiswa</th>
                        <th class="text-left px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Tipe Ujian</th>
                        <th class="text-left px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Jadwal Ujian</th>
                        <th class="text-left px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Status</th>
                        <th class="text-left px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($ujianList as $u)
                    <tr class="hover:bg-emerald-50/40 transition-colors">
                        <td class="px-4 py-3.5 font-bold text-slate-900">{{ $u->skripsi?->mahasiswa?->nama }}</td>
                        <td class="px-4 py-3.5 text-xs font-bold uppercase text-slate-700">{{ $u->tipe }}</td>
                        <td class="px-4 py-3.5 text-xs font-medium text-slate-600">{{ $u->jadwal ? date('d M Y H:i', strtotime($u->jadwal)) : '-' }}</td>
                        <td class="px-4 py-3.5">
                            <span class="status-badge bg-emerald-100 text-emerald-800 border border-emerald-200">{{ $u->status }}</span>
                        </td>
                        <td class="px-4 py-3.5">
                            <a href="{{ route('admin.ujian.show', $u) }}" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-bold rounded-lg transition-all">Detail &amp; Penguji</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-12 text-center text-slate-400 font-medium">Belum ada jadwal ujian</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(method_exists($ujianList, 'hasPages') && $ujianList->hasPages())
        <div class="mt-4">{{ $ujianList->links() }}</div>
        @endif
    </div>
</div>
@endsection