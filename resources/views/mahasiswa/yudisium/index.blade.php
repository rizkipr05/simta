@extends("layouts.app")
@section("title", "Yudisium")
@section("breadcrumb", "Yudisium")

@section("content")
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Pendaftaran Yudisium</h1>
            <p class="text-xs text-slate-500 mt-1">Daftar, unggah berkas persyaratan, dan pantau status kelulusan Anda.</p>
        </div>
        <a href="{{ route('mahasiswa.dashboard') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition-all">
            ← Kembali ke Dashboard
        </a>
    </div>

    @if($pendaftaran)
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-slate-500">Status pendaftaran</p>
                    <h2 class="text-lg font-extrabold text-slate-900 mt-1">{{ ucfirst($pendaftaran->status) }}</h2>
                </div>
                <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-bold border {{ $pendaftaran->status === 'eligible' ? 'bg-emerald-100 text-emerald-800 border-emerald-200' : 'bg-blue-100 text-blue-800 border-blue-200' }}">
                    {{ ucfirst($pendaftaran->status) }}
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                    <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-slate-500">Periode</p>
                    <p class="mt-2 text-sm font-extrabold text-slate-900">{{ $pendaftaran->periode?->nama_periode ?? '-' }}</p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                    <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-slate-500">Tanggal daftar</p>
                    <p class="mt-2 text-sm font-extrabold text-slate-900">{{ $pendaftaran->tanggal_daftar?->format('d M Y') ?? '-' }}</p>
                </div>
            </div>

            <div class="space-y-3">
                <h3 class="text-sm font-extrabold text-slate-900">Berkas persyaratan</h3>
                @foreach($persyaratanList as $p)
                    @php $berkas = $pendaftaran->berkas?->firstWhere('persyaratan_id', $p->id); @endphp
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                        <div>
                            <p class="text-sm font-bold text-slate-900">
                                {{ $p->nama_persyaratan }}
                                @if($p->wajib)
                                    <span class="text-red-500">*</span>
                                @endif
                            </p>
                            <p class="text-xs text-slate-500 mt-1">{{ $p->deskripsi }}</p>
                        </div>

                        <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                            @if($berkas)
                                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-[10px] font-bold border {{ $berkas->status === 'verified' ? 'bg-emerald-100 text-emerald-800 border-emerald-200' : 'bg-amber-100 text-amber-800 border-amber-200' }}">
                                    {{ ucfirst($berkas->status) }}
                                </span>
                            @endif

                            <form method="POST" action="{{ route('mahasiswa.yudisium.upload', $p) }}" enctype="multipart/form-data" class="flex items-center gap-2">
                                @csrf
                                <input type="file" name="file" class="text-xs text-slate-500 file:mr-3 file:rounded-lg file:border-0 file:bg-slate-200 file:px-2.5 file:py-1.5 file:text-xs file:font-bold file:text-slate-700" accept=".pdf,.jpg,.png">
                                <button type="submit" class="px-3 py-1.5 rounded-lg bg-emerald-600 text-white text-xs font-bold hover:bg-emerald-700 transition">
                                    Upload
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @elseif($periodeAktif)
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-slate-500">Formulir pendaftaran</p>
                    <h2 class="text-lg font-extrabold text-slate-900 mt-1">Daftar yudisium</h2>
                </div>
                <span class="inline-flex items-center rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200 px-3 py-1 text-xs font-bold">
                    Periode aktif
                </span>
            </div>

            <div class="rounded-xl border border-blue-200 bg-blue-50 p-4 mb-6">
                <p class="font-extrabold text-blue-900">{{ $periodeAktif->nama_periode }}</p>
                <p class="text-sm text-blue-700 mt-1">Yudisium: {{ $periodeAktif->tanggal_yudisium?->format('d F Y') ?? '-' }}</p>
                <p class="text-sm text-blue-700">Tempat: {{ $periodeAktif->tempat ?? '-' }}</p>
            </div>

            <form method="POST" action="{{ route('mahasiswa.yudisium.daftar') }}">
                @csrf
                <input type="hidden" name="periode_id" value="{{ $periodeAktif->id }}">
                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-3 bg-emerald-600 text-white font-semibold rounded-xl hover:bg-emerald-700 transition-colors shadow-lg shadow-emerald-600/20">
                        Daftar Yudisium Sekarang
                    </button>
                </div>
            </form>
        </div>
    @else
        <div class="bg-white rounded-2xl border border-slate-200 p-12 shadow-sm text-center">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-slate-100 text-slate-500">
                <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <p class="mt-4 text-lg font-semibold text-slate-500">Tidak ada periode yudisium yang aktif saat ini.</p>
        </div>
    @endif
</div>
@endsection