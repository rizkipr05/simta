@extends("layouts.app")
@section("title", "Detail Mahasiswa")
@section("breadcrumb", "Detail Mahasiswa")

@section("content")
<div class="space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.master.mahasiswa.index') }}" class="text-emerald-700 hover:text-emerald-900 font-bold text-xs flex items-center gap-1.5">
            ← Kembali ke Data Mahasiswa
        </a>
    </div>

    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 space-y-6">
        <div class="flex items-center gap-6">
            <img src="{{ $mahasiswa->foto_url }}" class="w-20 h-20 rounded-2xl object-cover ring-4 ring-emerald-100 flex-shrink-0">
            <div>
                <h1 class="text-xl font-extrabold text-slate-900">{{ $mahasiswa->nama }}</h1>
                <p class="text-slate-500 text-xs font-mono mt-0.5">{{ $mahasiswa->nim }} · {{ $mahasiswa->prodi?->nama }}</p>
                <span class="status-badge bg-emerald-100 text-emerald-800 border border-emerald-200 mt-2">{{ $mahasiswa->status_label }}</span>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 text-sm border-t border-slate-100 pt-6">
            <div>
                <p class="text-xs text-slate-500 font-bold uppercase tracking-wider">Angkatan</p>
                <p class="font-semibold text-slate-900 mt-1">{{ $mahasiswa->angkatan ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-bold uppercase tracking-wider">Semester</p>
                <p class="font-semibold text-slate-900 mt-1">Semester {{ $mahasiswa->semester }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-bold uppercase tracking-wider">Email</p>
                <p class="font-semibold text-slate-900 mt-1">{{ $mahasiswa->email ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-bold uppercase tracking-wider">No. HP</p>
                <p class="font-semibold text-slate-900 mt-1">{{ $mahasiswa->no_hp ?? '-' }}</p>
            </div>
        </div>

        @if($mahasiswa->skripsi)
        <div class="p-4 bg-emerald-50 border border-emerald-100 rounded-xl">
            <p class="text-xs font-bold text-emerald-800 uppercase tracking-wider mb-1">Judul Skripsi</p>
            <p class="text-sm font-semibold text-slate-900 leading-snug">{{ $mahasiswa->skripsi->judul }}</p>
        </div>
        @endif
    </div>
</div>
@endsection