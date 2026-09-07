@extends("layouts.app")
@section("title", "Data Mahasiswa")
@section("breadcrumb", "Mahasiswa")

@section("content")
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Data Mahasiswa</h1>
            <p class="text-xs text-slate-500 mt-1">Kelola data seluruh mahasiswa Fakultas Teknik UMMU</p>
        </div>
        <a href="{{ route('admin.master.mahasiswa.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-xl shadow-md shadow-emerald-600/20 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Mahasiswa
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
        <form method="GET" class="flex flex-col sm:flex-row gap-3 mb-5">
            <div class="flex-1 relative">
                <input name="search" value="{{ request('search') }}" placeholder="Cari NIM / Nama Mahasiswa..." class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all text-slate-800">
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <select name="prodi_id" class="px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 text-slate-800 font-medium">
                <option value="">Semua Program Studi</option>
                @foreach($prodiList as $p)
                <option value="{{ $p->id }}" {{ request('prodi_id') == $p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white text-sm font-bold rounded-xl transition-all">Filter</button>
        </form>

        <div class="overflow-x-auto rounded-xl border border-slate-200">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-700">
                        <th class="text-left px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Mahasiswa</th>
                        <th class="text-left px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Program Studi</th>
                        <th class="text-left px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Semester</th>
                        <th class="text-left px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Status Skripsi</th>
                        <th class="text-left px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($mahasiswaList as $mhs)
                    <tr class="hover:bg-emerald-50/40 transition-colors">
                        <td class="px-4 py-3.5">
                            <div class="flex items-center gap-3">
                                <img src="{{ $mhs->foto_url }}" class="w-9 h-9 rounded-full object-cover ring-2 ring-slate-100 flex-shrink-0">
                                <div>
                                    <p class="font-bold text-slate-900 text-sm leading-tight">{{ $mhs->nama }}</p>
                                    <p class="text-xs text-slate-500 font-mono leading-tight mt-0.5">{{ $mhs->nim }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3.5 text-sm font-medium text-slate-700">{{ $mhs->prodi?->nama ?? '-' }}</td>
                        <td class="px-4 py-3.5 text-sm font-medium text-slate-600">Semester {{ $mhs->semester }}</td>
                        <td class="px-4 py-3.5">
                            <span class="status-badge bg-emerald-100 text-emerald-800 border border-emerald-200">{{ $mhs->status_label }}</span>
                        </td>
                        <td class="px-4 py-3.5">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.master.mahasiswa.show', $mhs) }}" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-bold rounded-lg transition-all">Detail</a>
                                <a href="{{ route('admin.master.mahasiswa.edit', $mhs) }}" class="px-3 py-1.5 bg-amber-100 hover:bg-amber-200 text-amber-900 text-xs font-bold rounded-lg transition-all">Edit</a>
                                <form method="POST" action="{{ route('admin.master.mahasiswa.destroy', $mhs) }}" onsubmit="return confirm('Yakin ingin menghapus data ini?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 bg-rose-100 hover:bg-rose-200 text-rose-700 text-xs font-bold rounded-lg transition-all">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-12 text-center text-slate-400 font-medium">Tidak ada data mahasiswa ditemukan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($mahasiswaList->hasPages())
        <div class="mt-4">
            {{ $mahasiswaList->links() }}
        </div>
        @endif
    </div>
</div>
@endsection