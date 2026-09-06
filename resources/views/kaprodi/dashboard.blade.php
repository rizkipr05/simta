@extends("layouts.app")
@section("title", "Dashboard Kaprodi")
@section("breadcrumb", "Dashboard Kaprodi")

@section("content")
<div class="space-y-6">
    <div class="overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-900 via-teal-900 to-slate-900 p-6 text-white shadow-xl ring-1 ring-emerald-800/50 sm:p-8">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <span class="inline-flex items-center gap-2 rounded-full border border-emerald-400/30 bg-emerald-500/10 px-3 py-1 text-[10px] font-bold uppercase tracking-[0.2em] text-emerald-200">
                    <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                    Program Studi FT UMMU
                </span>
                <h1 class="mt-3 text-2xl font-black tracking-tight sm:text-3xl">Selamat Datang, Kaprodi</h1>
                <p class="mt-2 max-w-2xl text-sm text-slate-200">
                    Pantau mahasiswa skripsi, progres bimbingan, ujian, dan yudisium dalam satu dashboard yang terintegrasi.
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('kaprodi.monitoring.index') }}" class="rounded-xl bg-emerald-500 px-4 py-2.5 text-xs font-extrabold text-slate-950 shadow-lg shadow-emerald-500/20 transition hover:bg-emerald-400">
                    Monitoring Skripsi
                </a>
                <a href="{{ route('kaprodi.yudisium.index') }}" class="rounded-xl border border-white/15 bg-white/10 px-4 py-2.5 text-xs font-extrabold text-white transition hover:bg-white/20">
                    Monitoring Yudisium
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Jumlah Mahasiswa Skripsi</p>
            <div class="mt-3 flex items-end justify-between gap-3">
                <span class="text-3xl font-black text-slate-900">{{ $stats['total_mahasiswa_skripsi'] ?? 0 }}</span>
                <span class="text-2xl">👥</span>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Skripsi Aktif / Selesai</p>
            <div class="mt-3 flex items-end justify-between gap-3">
                <span class="text-3xl font-black text-slate-900">{{ ($stats['skripsi_aktif'] ?? 0) }}/{{ ($stats['skripsi_selesai'] ?? 0) }}</span>
                <span class="text-2xl">📄</span>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Pengajuan Judul</p>
            <div class="mt-3 flex items-end justify-between gap-3">
                <span class="text-3xl font-black text-slate-900">{{ $stats['pengajuan_judul'] ?? 0 }}</span>
                <span class="text-2xl">📝</span>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Mahasiswa Siap Ujian</p>
            <div class="mt-3 flex items-end justify-between gap-3">
                <span class="text-3xl font-black text-slate-900">{{ $stats['mahasiswa_siap_ujian'] ?? 0 }}</span>
                <span class="text-2xl">✅</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-[1.4fr_0.9fr]">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="mb-4 flex items-center justify-between gap-3">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Progres</p>
                    <h2 class="mt-1 text-lg font-extrabold text-slate-900">Grafik Progress Skripsi Prodi</h2>
                </div>
                <a href="{{ route('kaprodi.statistik.index') }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-900">Statistik Prodi</a>
            </div>

            @if(!empty($prodiProgress))
                <div class="space-y-4">
                    @foreach($prodiProgress as $item)
                        @php $progress = $item['total'] ? (($item['aktif'] + $item['selesai']) / $item['total']) * 100 : 0; @endphp
                        <div>
                            <div class="mb-1 flex items-center justify-between text-xs font-bold text-slate-600">
                                <span>{{ $item['nama'] }}</span>
                                <span>{{ $item['aktif'] + $item['selesai'] }}/{{ $item['total'] }}</span>
                            </div>
                            <div class="h-2.5 w-full overflow-hidden rounded-full bg-slate-100">
                                <div class="h-full rounded-full bg-emerald-500" style="width: {{ $progress }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="rounded-xl border border-dashed border-slate-200 bg-slate-50 p-4 text-sm text-slate-500">Belum ada data progress prodi.</div>
            @endif
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Ringkasan</p>
            <h2 class="mt-1 text-lg font-extrabold text-slate-900">Yudisium &amp; Bimbingan</h2>

            <div class="mt-4 space-y-3">
                <div class="rounded-xl bg-slate-50 p-3">
                    <p class="text-xs text-slate-500">Mahasiswa Bimbingan</p>
                    <p class="mt-1 text-2xl font-black text-slate-900">{{ $stats['mahasiswa_bimbingan'] ?? 0 }}</p>
                </div>
                <div class="rounded-xl bg-slate-50 p-3">
                    <p class="text-xs text-slate-500">Calon Yudisium</p>
                    <p class="mt-1 text-2xl font-black text-slate-900">{{ $stats['yudisium'] ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="mb-4 flex items-center justify-between gap-3">
            <div>
                <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Monitoring</p>
                <h2 class="mt-1 text-lg font-extrabold text-slate-900">Daftar Mahasiswa Skripsi</h2>
            </div>
            <a href="{{ route('kaprodi.monitoring.index') }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-900">Lihat semua</a>
        </div>

        <div class="overflow-x-auto rounded-xl border border-slate-200 mt-2">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-700">
                    <tr>
                        <th class="px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Mahasiswa</th>
                        <th class="px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Judul</th>
                        <th class="px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Pembimbing</th>
                        <th class="px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Progress</th>
                        <th class="px-4 py-3.5 text-xs font-bold uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($recentSkripsi as $skripsi)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-4 py-3.5">
                                <p class="font-bold text-slate-900">{{ $skripsi->mahasiswa?->nama ?? '-' }}</p>
                                <p class="text-[11px] text-slate-500 font-mono mt-0.5">{{ $skripsi->mahasiswa?->nim ?? '-' }}</p>
                            </td>
                            <td class="px-4 py-3.5 text-slate-700 text-xs leading-relaxed max-w-sm truncate" title="{{ $skripsi->judul }}">{{ $skripsi->judul }}</td>
                            <td class="px-4 py-3.5 text-slate-700 font-medium">{{ $skripsi->pembimbing1?->dosen?->nama ?? '-' }}</td>
                            <td class="px-4 py-3.5">
                                <div class="w-28 overflow-hidden rounded-full bg-slate-100 border border-slate-200 shadow-inner">
                                    <div class="h-2 rounded-full {{ $skripsi->status === 'selesai' ? 'bg-emerald-500' : ($skripsi->status === 'aktif' ? 'bg-amber-400' : 'bg-slate-300') }}" style="width: {{ $skripsi->status === 'selesai' ? 100 : ($skripsi->status === 'aktif' ? 45 : 15) }}%"></div>
                                </div>
                            </td>
                            <td class="px-4 py-3.5">
                                @if($skripsi->mahasiswa)
                                    <a href="{{ route('kaprodi.monitoring.show', $skripsi->mahasiswa) }}" class="inline-flex rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-[11px] font-bold text-slate-700 shadow-sm transition-all hover:border-emerald-300 hover:bg-emerald-50 hover:text-emerald-800">Detail</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-12 text-center text-sm text-slate-500">Belum ada data mahasiswa skripsi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection