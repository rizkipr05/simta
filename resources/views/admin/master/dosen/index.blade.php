@extends("layouts.app")
@section("title", "Data Dosen")
@section("breadcrumb", "Dosen")

@section("content")
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Data Dosen</h1>
            <p class="text-xs text-slate-500 mt-1">Kelola data dosen pembimbing & penguji Fakultas Teknik UMMU</p>
        </div>
        <a href="{{ route('admin.master.dosen.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-xl shadow-md shadow-emerald-600/20 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Dosen
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
        <div class="overflow-x-auto rounded-xl border border-slate-200">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-700">
                        <th class="text-left px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Dosen</th>
                        <th class="text-left px-4 py-3.5 text-xs font-bold uppercase tracking-wider">NIDN</th>
                        <th class="text-left px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Program Studi</th>
                        <th class="text-left px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Jabatan Fungsional</th>
                        <th class="text-left px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($dosenList as $d)
                    <tr class="hover:bg-emerald-50/40 transition-colors">
                        <td class="px-4 py-3.5">
                            <p class="font-bold text-slate-900 text-sm leading-tight">{{ $d->nama_lengkap }}</p>
                            <p class="text-xs text-slate-500 leading-tight mt-0.5">{{ $d->email }}</p>
                        </td>
                        <td class="px-4 py-3.5 text-sm font-mono font-medium text-slate-700">{{ $d->nidn }}</td>
                        <td class="px-4 py-3.5 text-sm font-medium text-slate-700">{{ $d->prodi?->nama ?? '-' }}</td>
                        <td class="px-4 py-3.5 text-sm font-medium text-slate-600">{{ $d->jabatan ?? '-' }}</td>
                        <td class="px-4 py-3.5">
                            <a href="{{ route('admin.master.dosen.edit', $d) }}" class="px-3 py-1.5 bg-amber-100 hover:bg-amber-200 text-amber-900 text-xs font-bold rounded-lg transition-all">Edit</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-12 text-center text-slate-400 font-medium">Belum ada data dosen</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($dosenList->hasPages())
        <div class="mt-4">{{ $dosenList->links() }}</div>
        @endif
    </div>
</div>
@endsection