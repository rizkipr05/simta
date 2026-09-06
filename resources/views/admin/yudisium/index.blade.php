@extends("layouts.app")
@section("title", "Yudisium")
@section("breadcrumb", "Yudisium")

@section("content")
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Pendaftaran Yudisium</h1>
            <p class="text-xs text-slate-500 mt-1">Verifikasi kelayakan yudisium dan penetapan lulusan Fakultas Teknik</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
        <div class="overflow-x-auto rounded-xl border border-slate-200">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-700">
                        <th class="text-left px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Mahasiswa</th>
                        <th class="text-left px-4 py-3.5 text-xs font-bold uppercase tracking-wider">IPK</th>
                        <th class="text-left px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Bebas Pustaka</th>
                        <th class="text-left px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Status Verification</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @php $items = $yudisiumList ?? ($periodeList ?? []); @endphp
                    @forelse($items as $y)
                    <tr class="hover:bg-emerald-50/40 transition-colors">
                        <td class="px-4 py-3.5 font-bold text-slate-900">{{ $y->mahasiswa?->nama ?? ($y->nama_periode ?? 'Periode Yudisium') }}</td>
                        <td class="px-4 py-3.5 font-mono text-xs font-bold text-slate-800">{{ $y->ipk ?? '3.75' }}</td>
                        <td class="px-4 py-3.5">
                            <span class="status-badge bg-emerald-100 text-emerald-800 border border-emerald-200">Lengkap</span>
                        </td>
                        <td class="px-4 py-3.5">
                            <span class="status-badge bg-emerald-100 text-emerald-800 border border-emerald-200">{{ $y->status ?? 'LULUS' }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-12 text-center text-slate-400 font-medium">Belum ada pendaftaran yudisium</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection