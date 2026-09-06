@extends("layouts.app")
@section("title", "Monitoring Skripsi")
@section("breadcrumb", "Monitoring Skripsi")

@section("content")
<div class="space-y-6">
    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Monitoring Skripsi</h1>
            <p class="mt-1 text-xs text-slate-500">Daftar mahasiswa, judul, pembimbing, progress, revisi, dan status ujian.</p>
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 p-4">
            <form method="GET" class="flex flex-col gap-3 md:flex-row">
                <input name="search" value="{{ request('search') }}" placeholder="Cari nama / NIM..." class="flex-1 rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                <select name="status" class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                    <option value="">Semua Status</option>
                    @foreach(App\Models\Mahasiswa::statusLabels() as $key => $label)
                        <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                <button class="rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-bold text-white hover:bg-emerald-700">Filter</button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Mahasiswa</th>
                        <th class="px-4 py-3 text-left text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Judul</th>
                        <th class="px-4 py-3 text-left text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Pembimbing</th>
                        <th class="px-4 py-3 text-left text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Progress</th>
                        <th class="px-4 py-3 text-left text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Bimbingan</th>
                        <th class="px-4 py-3 text-left text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Status</th>
                        <th class="px-4 py-3 text-left text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($mahasiswaList as $mhs)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3">
                                <p class="font-bold text-slate-900">{{ $mhs->nama }}</p>
                                <p class="text-xs text-slate-500">{{ $mhs->nim }}</p>
                            </td>
                            <td class="px-4 py-3 text-slate-700">{{ $mhs->skripsi?->judul ? Str::limit($mhs->skripsi->judul, 55) : '-' }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $mhs->skripsi?->pembimbing1?->dosen?->nama ?? '-' }}</td>
                            <td class="px-4 py-3">
                                <div class="w-28 overflow-hidden rounded-full bg-slate-100">
                                    <div class="h-2 rounded-full bg-emerald-500" style="width: {{ $mhs->progress ?? 0 }}%"></div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-slate-700">{{ $mhs->bimbingan_count ?? 0 }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-1 text-[10px] font-bold uppercase text-emerald-800">{{ $mhs->status_label }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <a href="{{ route('kaprodi.monitoring.show', $mhs) }}" class="rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-bold text-slate-700 hover:bg-emerald-100 hover:text-emerald-800">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-12 text-center text-sm text-slate-400">Belum ada data mahasiswa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($mahasiswaList->hasPages())
            <div class="border-t border-slate-200 p-4">
                {{ $mahasiswaList->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
