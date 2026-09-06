@extends("layouts.app")
@section("title", "Riwayat Pengajuan Skripsi")
@section("breadcrumb", "Riwayat Pengajuan")

@section("content")
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Riwayat Pengajuan & Proses Akademik</h1>
            <p class="text-xs text-slate-500 mt-1">Lacak seluruh riwayat kronologis judul, bimbingan, dokumen, hingga yudisium.</p>
        </div>
        <a href="{{ route('mahasiswa.dashboard') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition-all">
            &larr; Kembali ke Dashboard
        </a>
    </div>

    @php
        $logs = collect();

        if ($skripsi) {
            $logs->push([
                'kategori' => 'Judul Skripsi',
                'judul' => 'Pengajuan Awal',
                'deskripsi' => \Illuminate\Support\Str::limit($skripsi->judul, 70),
                'tanggal' => $skripsi->created_at,
                'status' => $skripsi->status,
            ]);

            foreach($skripsi->bimbingan as $b) {
                $logs->push([
                    'kategori' => 'Bimbingan',
                    'judul' => $b->topik,
                    'deskripsi' => $b->bab_bimbingan,
                    'tanggal' => $b->tanggal_bimbingan ?: $b->created_at,
                    'status' => $b->status,
                ]);
            }

            foreach($skripsi->dokumen as $d) {
                $logs->push([
                    'kategori' => 'Dokumen',
                    'judul' => 'Unggah ' . ucfirst($d->jenis),
                    'deskripsi' => $d->nama,
                    'tanggal' => $d->uploaded_at ?: $d->created_at,
                    'status' => $d->status,
                ]);
            }

            $yudisium = $skripsi->mahasiswa->pendaftaranYudisium()->latest()->first();
            if ($yudisium) {
                $logs->push([
                    'kategori' => 'Yudisium',
                    'judul' => 'Pendaftaran Yudisium',
                    'deskripsi' => 'Pengajuan pendaftaran yudisium',
                    'tanggal' => $yudisium->created_at,
                    'status' => $yudisium->status,
                ]);
            }
        }
        
        $logs = $logs->sortByDesc('tanggal');
    @endphp

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-200 bg-slate-50/50 flex flex-col md:flex-row md:items-center justify-between gap-3">
            <h2 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider">Log Riwayat Akademik</h2>
            <div class="text-xs font-bold text-slate-500 bg-white border border-slate-200 px-3 py-1.5 rounded-lg shadow-sm">
                Total Aktivitas: {{ $logs->count() }}
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200">
                        <th class="px-5 py-4 text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">TANGGAL</th>
                        <th class="px-5 py-4 text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">KATEGORI</th>
                        <th class="px-5 py-4 text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">RINCIAN AKTIVITAS</th>
                        <th class="px-5 py-4 text-[10px] font-extrabold text-slate-500 uppercase tracking-wider text-center">STATUS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($logs as $log)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-5 py-4 align-middle whitespace-nowrap">
                            <span class="text-xs font-bold text-slate-700">{{ $log['tanggal'] ? $log['tanggal']->format('d M Y') : '-' }}</span>
                            <br>
                            <span class="text-[10px] font-semibold text-slate-400">{{ $log['tanggal'] ? $log['tanggal']->format('H:i') : '-' }}</span>
                        </td>
                        <td class="px-5 py-4 align-middle whitespace-nowrap">
                            <span class="inline-flex px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase tracking-wide
                                {{ $log['kategori'] === 'Judul Skripsi' ? 'bg-indigo-100 text-indigo-700' : 
                                  ($log['kategori'] === 'Bimbingan' ? 'bg-emerald-100 text-emerald-700' : 
                                  ($log['kategori'] === 'Dokumen' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700')) }}">
                                {{ $log['kategori'] }}
                            </span>
                        </td>
                        <td class="px-5 py-4 align-middle">
                            <p class="text-sm font-bold text-slate-900">{{ $log['judul'] }}</p>
                            <p class="text-xs font-medium text-slate-500 mt-1">{{ $log['deskripsi'] }}</p>
                        </td>
                        <td class="px-5 py-4 align-middle text-center whitespace-nowrap">
                            @php
                                $status = strtolower($log['status']);
                                $statusClass = 'bg-slate-100 text-slate-700 border-slate-200';
                                if (in_array($status, ['aktif', 'approved', 'diterima'])) $statusClass = 'bg-emerald-100 text-emerald-800 border-emerald-200';
                                elseif (in_array($status, ['revision', 'ditolak', 'rejected'])) $statusClass = 'bg-rose-100 text-rose-800 border-rose-200';
                                elseif (in_array($status, ['pengajuan', 'pending'])) $statusClass = 'bg-amber-100 text-amber-800 border-amber-200';
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border {{ $statusClass }}">
                                {{ str_replace('_', ' ', $status) ?: '-' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-5 py-12 text-center">
                            <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <p class="text-sm font-bold text-slate-600">Belum Ada Terekam Aktivitas</p>
                            <p class="text-xs text-slate-400 mt-1">Riwayat judul, bimbingan, atau dokumen akan tercatat otomatis di sini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
