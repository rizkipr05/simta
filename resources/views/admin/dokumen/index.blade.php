@extends("layouts.app")
@section("title", "Repository Dokumen")
@section("breadcrumb", "Repository Dokumen")

@section("content")
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Repository Dokumen Terpusat</h1>
            <p class="text-xs text-slate-500 mt-1">Pusat arsip SK Pembimbing, SK Penguji, Berita Acara, Pengesahan, dan Berkas Yudisium</p>
        </div>
    </div>

    {{-- Filter --}}
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
        <form method="GET" action="{{ route('admin.dokumen.index') }}" class="flex flex-wrap items-center gap-3 w-full md:w-auto">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama berkas, mahasiswa, NIM..." class="px-4 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none w-full md:w-64">
            <select name="jenis" class="px-4 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                <option value="">Semua Jenis Dokumen</option>
                <option value="sk_pembimbing" {{ request('jenis') == 'sk_pembimbing' ? 'selected' : '' }}>SK Pembimbing</option>
                <option value="sk_penguji" {{ request('jenis') == 'sk_penguji' ? 'selected' : '' }}>SK Penguji</option>
                <option value="undangan_ujian" {{ request('jenis') == 'undangan_ujian' ? 'selected' : '' }}>Undangan Ujian</option>
                <option value="berita_acara" {{ request('jenis') == 'berita_acara' ? 'selected' : '' }}>Berita Acara</option>
                <option value="lembar_pengesahan_signed" {{ request('jenis') == 'lembar_pengesahan_signed' ? 'selected' : '' }}>Lembar Pengesahan TTD</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-slate-800 text-white text-xs font-bold rounded-xl hover:bg-slate-700 transition-all">Filter</button>
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase font-bold tracking-wider">
                    <tr>
                        <th class="px-6 py-3.5">Nama Dokumen</th>
                        <th class="px-6 py-3.5">Jenis</th>
                        <th class="px-6 py-3.5">Mahasiswa</th>
                        <th class="px-6 py-3.5">Diupload Oleh</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($dokumen as $d)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <p class="font-extrabold text-slate-900 text-sm">{{ $d->nama }}</p>
                            <p class="text-slate-400 text-[11px] mt-0.5">{{ $d->created_at ? $d->created_at->format('d M Y, H:i') : '-' }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase border bg-blue-50 text-blue-700 border-blue-200">
                                {{ str_replace('_', ' ', $d->jenis) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-semibold text-slate-800">
                            {{ $d->skripsi?->mahasiswa?->nama ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-slate-700 font-medium">
                            {{ $d->uploadedBy->name ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ Storage::url($d->file_path) }}" target="_blank" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-sm transition-all inline-flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                Unduh
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-400 font-semibold">Belum ada dokumen terarsip.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100">
            {{ $dokumen->links() }}
        </div>
    </div>
</div>
@endsection
