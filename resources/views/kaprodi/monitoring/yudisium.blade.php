@extends("layouts.app")
@section("title", "Monitoring Yudisium")
@section("breadcrumb", "Monitoring Yudisium")

@section("content")
<div class="space-y-6">
    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Monitoring Yudisium</h1>
            <p class="mt-1 text-xs text-slate-500">Daftar calon yudisium, kelengkapan dokumen, status verifikasi, IPK, periode, dan syarat kelulusan.</p>
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Mahasiswa</th>
                        <th class="px-4 py-3 text-left text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">IPK</th>
                        <th class="px-4 py-3 text-left text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Status Skripsi</th>
                        <th class="px-4 py-3 text-left text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Periode</th>
                        <th class="px-4 py-3 text-left text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Dokumen</th>
                        <th class="px-4 py-3 text-left text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Status Verifikasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($yudisiumList as $y)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3">
                                <p class="font-bold text-slate-900">{{ $y->mahasiswa?->nama }}</p>
                                <p class="text-xs text-slate-500">{{ $y->mahasiswa?->nim }}</p>
                            </td>
                            <td class="px-4 py-3 font-mono text-xs font-bold text-slate-800">{{ $y->ipk ?? '0.00' }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-1 text-[10px] font-bold uppercase text-emerald-800">{{ $y->mahasiswa?->status_label ?? '-' }}</span>
                            </td>
                            <td class="px-4 py-3 text-slate-700">{{ $y->periode?->nama_periode ?? '-' }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $y->dokumen_terlengkap ? 'Lengkap' : 'Belum Lengkap' }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex rounded-full {{ $y->status_verifikasi === 'Terverifikasi' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }} px-2.5 py-1 text-[10px] font-bold uppercase">{{ $y->status_verifikasi }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center text-sm text-slate-400">Belum ada mahasiswa daftar yudisium.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($yudisiumList->hasPages())
            <div class="border-t border-slate-200 p-4">
                {{ $yudisiumList->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
