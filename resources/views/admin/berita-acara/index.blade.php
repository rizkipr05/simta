@extends("layouts.app")
@section("title", "Berita Acara Ujian")
@section("breadcrumb", "Berita Acara")

@section("content")
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Berita Acara Ujian</h1>
            <p class="text-xs text-slate-500 mt-1">Daftar Berita Acara Hasil Ujian Skripsi &amp; Rekap Nilai Munaqasyah</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
        <div class="overflow-x-auto rounded-xl border border-slate-200">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-700">
                        <th class="text-left px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Nomor BA</th>
                        <th class="text-left px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Mahasiswa</th>
                        <th class="text-left px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Nilai Akhir</th>
                        <th class="text-left px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Grade</th>
                        <th class="text-left px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($baList as $ba)
                    <tr class="hover:bg-emerald-50/40 transition-colors">
                        <td class="px-4 py-3.5 font-bold font-mono text-xs text-slate-900">{{ $ba->nomor_ba ?? 'BA #' . $ba->id }}</td>
                        <td class="px-4 py-3.5 font-medium text-slate-800">{{ $ba->ujian?->skripsi?->mahasiswa?->nama ?? '-' }}</td>
                        <td class="px-4 py-3.5 font-mono text-xs font-bold text-slate-900">{{ $ba->nilai_akhir ?? '-' }}</td>
                        <td class="px-4 py-3.5">
                            <span class="status-badge bg-emerald-100 text-emerald-800 border border-emerald-200">{{ $ba->grade ?? 'A' }}</span>
                        </td>
                        <td class="px-4 py-3.5">
                            <a href="{{ route('admin.berita-acara.pdf', $ba) }}" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-lg transition-all shadow-sm">Cetak PDF</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-12 text-center text-slate-400 font-medium">Belum ada Berita Acara</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(method_exists($baList, 'hasPages') && $baList->hasPages())
        <div class="mt-4">{{ $baList->links() }}</div>
        @endif
    </div>
</div>
@endsection