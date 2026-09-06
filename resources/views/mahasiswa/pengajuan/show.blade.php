@extends("layouts.app")
@section("title", "Detail Pengajuan Skripsi")
@section("breadcrumb", "Detail Pengajuan")

@section("content")
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Detail Pengajuan Skripsi</h1>
            <p class="text-xs text-slate-500 mt-1">Informasi lengkap mengenai usulan judul skripsi Anda</p>
        </div>
        <a href="{{ route('mahasiswa.pengajuan.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition-all">
            &larr; Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="border-b border-slate-200 px-5 py-4 bg-slate-50/50">
            <h2 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider">Data Pengajuan Skripsi</h2>
        </div>
        
        <div class="p-6 space-y-6">
            <div>
                <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Judul Skripsi</p>
                <p class="mt-1 text-lg font-extrabold text-slate-900">{{ $skripsi->judul }}</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Bidang Kajian</p>
                    <p class="mt-1 text-sm font-bold text-slate-700">{{ $skripsi->bidang_kajian ?: '-' }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Status Pengajuan</p>
                    <div class="mt-1">
                        @php
                            $status = strtolower($skripsi->status ?? 'pengajuan');
                            $statusClass = 'bg-slate-100 text-slate-700 border-slate-200';
                            if (in_array($status, ['aktif', 'selesai'])) $statusClass = 'bg-emerald-100 text-emerald-800 border-emerald-200';
                            elseif (in_array($status, ['ditolak'])) $statusClass = 'bg-rose-100 text-rose-800 border-rose-200';
                            elseif (in_array($status, ['pengajuan'])) $statusClass = 'bg-amber-100 text-amber-800 border-amber-200';
                        @endphp
                        <span class="inline-flex px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider border {{ $statusClass }}">
                            {{ str_replace('_', ' ', $status) }}
                        </span>
                    </div>
                </div>
            </div>

            <div>
                <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Deskripsi Singkat</p>
                <div class="mt-2 p-4 bg-slate-50 rounded-xl border border-slate-100">
                    <p class="text-sm text-slate-700 leading-relaxed">{{ $skripsi->deskripsi ?: 'Tidak ada deskripsi' }}</p>
                </div>
            </div>
            
            @if($skripsi->catatan_penolakan)
            <div>
                <p class="text-[10px] font-extrabold text-rose-500 uppercase tracking-wider">Catatan Penolakan / Revisi</p>
                <div class="mt-2 p-4 bg-rose-50 rounded-xl border border-rose-100">
                    <p class="text-sm text-rose-800 font-medium leading-relaxed">{{ $skripsi->catatan_penolakan }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection