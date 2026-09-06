@extends("layouts.app")
@section("title", "Dashboard Super Admin")
@section("breadcrumb", "Dashboard Super Admin")

@section("content")
<div class="space-y-5">
    <div class="overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-emerald-900 to-emerald-700 p-5 shadow-xl ring-1 ring-emerald-950/50 sm:p-6">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <span class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/10 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.2em] text-emerald-100">
                    <span class="h-2 w-2 rounded-full bg-emerald-300"></span>
                    SUPER ADMIN SIMTA
                </span>
                <h1 class="mt-3 text-2xl font-black tracking-tight text-white sm:text-3xl">Selamat Datang, {{ auth()->user()->name }}</h1>
                <p class="mt-2 max-w-2xl text-sm text-emerald-100">
                    Pantau status mahasiswa, skripsi, dan yudisium secara ringkas dalam satu dashboard.
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.users.index') }}" class="rounded-xl bg-yellow-400 px-3.5 py-2 text-xs font-extrabold text-slate-950 shadow-lg shadow-yellow-500/20 transition hover:bg-yellow-300">
                    Kelola User
                </a>
                <a href="{{ route('admin.skripsi.index') }}" class="rounded-xl border border-white/15 bg-white/10 px-3.5 py-2 text-xs font-extrabold text-white transition hover:bg-white/20">
                    Review Skripsi
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Mahasiswa</p>
                    <p class="mt-2 text-2xl font-black text-slate-900">{{ $stats['total_mahasiswa'] }}</p>
                </div>
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 text-lg text-emerald-700">👥</div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Dosen</p>
                    <p class="mt-2 text-2xl font-black text-slate-900">{{ $stats['total_dosen'] }}</p>
                </div>
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-sky-100 text-lg text-sky-700">🎓</div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Skripsi</p>
                    <p class="mt-2 text-2xl font-black text-slate-900">{{ $stats['total_skripsi'] }}</p>
                </div>
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-100 text-lg text-violet-700">📄</div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Yudisium</p>
                    <p class="mt-2 text-2xl font-black text-slate-900">{{ $stats['total_yudisium'] }}</p>
                </div>
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100 text-lg text-amber-700">🏅</div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-5 xl:grid-cols-[1.4fr_0.9fr]">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="mb-4 flex items-center justify-between gap-3">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Status</p>
                    <h2 class="mt-1 text-lg font-extrabold text-slate-900">Ringkasan skripsi</h2>
                </div>
                <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-1 text-[10px] font-bold uppercase text-emerald-800">
                    {{ $stats['pending_pengajuan'] }} menunggu
                </span>
            </div>

            @php $totalStatus = max(1, array_sum($skripsiStatusBreakdown)); @endphp
            <div class="space-y-3">
                @foreach([
                    ['key' => 'pengajuan', 'label' => 'Pengajuan', 'color' => 'amber'],
                    ['key' => 'aktif', 'label' => 'Aktif', 'color' => 'emerald'],
                    ['key' => 'selesai', 'label' => 'Selesai', 'color' => 'sky'],
                    ['key' => 'ditolak', 'label' => 'Ditolak', 'color' => 'rose'],
                ] as $status)
                    <div>
                        <div class="mb-1 flex items-center justify-between text-xs font-bold text-slate-600">
                            <span>{{ $status['label'] }}</span>
                            <span>{{ $skripsiStatusBreakdown[$status['key']] }}</span>
                        </div>
                        <div class="h-2.5 w-full overflow-hidden rounded-full bg-slate-100">
                            <div class="h-full rounded-full bg-{{ $status['color'] }}-500" style="width: {{ ($skripsiStatusBreakdown[$status['key']] / $totalStatus) * 100 }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Agenda</p>
            <h2 class="mt-1 text-lg font-extrabold text-slate-900">Ujian terdekat</h2>

            @if($nearestExam)
                <div class="mt-4 rounded-2xl border border-sky-200 bg-sky-50 p-4">
                    <p class="text-sm font-extrabold text-sky-900">{{ $nearestExam->skripsi?->mahasiswa?->nama ?? 'Mahasiswa' }}</p>
                    <p class="mt-1 text-xs text-sky-700 line-clamp-2">{{ $nearestExam->skripsi?->judul ?? 'Judul tidak tersedia' }}</p>
                    <div class="mt-3 space-y-1 text-xs text-sky-800">
                        <p><span class="font-bold">Tanggal:</span> {{ $nearestExam->jadwal?->format('d M Y') }}</p>
                        <p><span class="font-bold">Jam:</span> {{ $nearestExam->jadwal?->format('H:i') }}</p>
                        <p><span class="font-bold">Ruangan:</span> {{ $nearestExam->ruangan ?? '-' }}</p>
                    </div>
                </div>
            @else
                <div class="mt-4 rounded-2xl border border-dashed border-slate-200 bg-slate-50 p-4 text-sm text-slate-500">
                    Belum ada jadwal ujian.
                </div>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 gap-5 xl:grid-cols-[1.2fr_0.8fr]">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="mb-4 flex items-center justify-between gap-3">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Aktivitas</p>
                    <h2 class="mt-1 text-lg font-extrabold text-slate-900">Log terbaru</h2>
                </div>
                <a href="{{ route('admin.audit-log.index') }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-900">Lihat semua</a>
            </div>

            <div class="space-y-2.5">
                @forelse($recentActivities as $log)
                    <div class="flex items-start gap-3 rounded-xl border border-slate-200 bg-slate-50 p-3">
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-emerald-100 text-[10px] font-black text-emerald-700">
                            {{ strtoupper(substr($log->user?->name ?? 'S', 0, 1)) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-bold text-slate-900">{{ $log->action }}</p>
                            <p class="text-xs text-slate-500">{{ $log->model }} • {{ $log->user?->name ?? 'Sistem' }} • {{ $log->created_at?->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <div class="rounded-xl border border-dashed border-slate-200 bg-slate-50 p-4 text-sm text-slate-500">
                        Belum ada aktivitas terbaru.
                    </div>
                @endforelse
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Shortcut</p>
            <h2 class="mt-1 text-lg font-extrabold text-slate-900">Proses cepat</h2>

            <div class="mt-4 space-y-2.5">
                @foreach(array_slice($shortcuts, 0, 5) as $shortcut)
                    <a href="{{ route($shortcut['route']) }}" class="flex items-center justify-between gap-3 rounded-xl border border-slate-200 bg-slate-50 p-3 transition hover:border-emerald-200 hover:bg-emerald-50">
                        <div class="flex items-center gap-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-{{ $shortcut['color'] }}-100 text-base">
                                {{ $shortcut['icon'] }}
                            </div>
                            <span class="text-sm font-bold text-slate-800">{{ $shortcut['label'] }}</span>
                        </div>
                        <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
