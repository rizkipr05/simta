@extends("layouts.app")
@section("title", "Program Studi")
@section("breadcrumb", "Program Studi")

@section("content")
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Program Studi</h1>
            <p class="text-xs text-slate-500 mt-1">Daftar Program Studi lingkungan Fakultas Teknik UMMU</p>
        </div>
        <a href="{{ route('admin.master.program-studi.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-xl shadow-md shadow-emerald-600/20 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Prodi
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
        <div class="overflow-x-auto rounded-xl border border-slate-200">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-700">
                        <th class="text-left px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Kode</th>
                        <th class="text-left px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Nama Program Studi</th>
                        <th class="text-left px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Jenjang</th>
                        <th class="text-left px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Akreditasi</th>
                        <th class="text-left px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($prodiList as $p)
                    <tr class="hover:bg-emerald-50/40 transition-colors">
                        <td class="px-4 py-3.5 font-mono text-xs font-bold text-slate-800">{{ $p->kode }}</td>
                        <td class="px-4 py-3.5 font-bold text-slate-900">{{ $p->nama }}</td>
                        <td class="px-4 py-3.5 text-xs font-semibold text-slate-700 uppercase">{{ $p->jenjang }}</td>
                        <td class="px-4 py-3.5">
                            <span class="status-badge bg-emerald-100 text-emerald-800 border border-emerald-200">{{ $p->akreditasi ?? 'Unggul' }}</span>
                        </td>
                        <td class="px-4 py-3.5">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.master.program-studi.edit', $p) }}" class="px-3 py-1.5 bg-amber-100 hover:bg-amber-200 text-amber-900 text-xs font-bold rounded-lg transition-all">Edit</a>
                                <form method="POST" action="{{ route('admin.master.program-studi.destroy', $p) }}" onsubmit="return confirm('Yakin ingin menghapus data ini?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 bg-rose-100 hover:bg-rose-200 text-rose-700 text-xs font-bold rounded-lg transition-all">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-12 text-center text-slate-400 font-medium">Belum ada data prodi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection