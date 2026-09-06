@extends("layouts.app")
@section("title", "Tahun Akademik")
@section("breadcrumb", "Tahun Akademik")

@section("content")
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Tahun Akademik</h1>
            <p class="text-xs text-slate-500 mt-1">Daftar periode tahun akademik dan semester aktif</p>
        </div>
        <a href="{{ route('admin.master.tahun-akademik.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-xl shadow-md shadow-emerald-600/20 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Tahun Akademik
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
        <div class="overflow-x-auto rounded-xl border border-slate-200">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-700">
                        <th class="text-left px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Tahun</th>
                        <th class="text-left px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Semester</th>
                        <th class="text-left px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Status Aktif</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($tahunList as $t)
                    <tr class="hover:bg-emerald-50/40 transition-colors">
                        <td class="px-4 py-3.5 font-bold text-slate-900">{{ $t->tahun }}</td>
                        <td class="px-4 py-3.5 text-xs font-semibold text-slate-700 capitalize">{{ $t->semester }}</td>
                        <td class="px-4 py-3.5">
                            @if($t->is_aktif)
                            <span class="status-badge bg-emerald-100 text-emerald-800 border border-emerald-200">Aktif</span>
                            @else
                            <span class="status-badge bg-slate-100 text-slate-600 border border-slate-200">Tidak Aktif</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-4 py-12 text-center text-slate-400 font-medium">Belum ada tahun akademik</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection