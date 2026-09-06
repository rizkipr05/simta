@extends('layouts.app')
@section('title', 'Input Nilai Sidang')
@section('breadcrumb', 'Input Nilai Sidang')

@section('content')
<div class="max-w-3xl space-y-6">
    <a href="{{ route('dosen.nilai.index') }}" class="text-xs font-semibold text-emerald-700 hover:text-emerald-900">← Kembali ke daftar penilaian</a>

    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
        <div class="mb-6">
            <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-slate-500">Mahasiswa</p>
            <h1 class="mt-2 text-2xl font-extrabold text-slate-900">{{ $penguji->ujian?->skripsi?->mahasiswa?->nama ?? '-' }}</h1>
            <p class="text-sm text-slate-500 mt-1">{{ $penguji->ujian?->skripsi?->judul ?? '-' }}</p>
        </div>

        <form method="POST" action="{{ route('dosen.nilai.store') }}" class="space-y-5">
            @csrf
            <input type="hidden" name="penguji_id" value="{{ $penguji->id }}">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Nilai Penguasaan Materi</label>
                    <input type="number" name="nilai_penguasaan_materi" step="0.1" min="0" max="100" value="{{ $penguji->nilai?->nilai_penguasaan_materi ?? '' }}" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Nilai Presentasi</label>
                    <input type="number" name="nilai_kemampuan_presentasi" step="0.1" min="0" max="100" value="{{ $penguji->nilai?->nilai_kemampuan_presentasi ?? '' }}" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Nilai Penulisan</label>
                    <input type="number" name="nilai_penulisan" step="0.1" min="0" max="100" value="{{ $penguji->nilai?->nilai_penulisan ?? '' }}" class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500" required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Catatan Penguji</label>
                <textarea name="catatan" rows="4" class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500">{{ $penguji->nilai?->catatan ?? '' }}</textarea>
            </div>

            @if($penguji->nilai)
                <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4">
                    <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-emerald-700">Nilai Saat Ini</p>
                    <p class="mt-2 text-2xl font-extrabold text-emerald-700">{{ $penguji->nilai->nilai_total }} <span class="text-base font-semibold">({{ $penguji->nilai->grade }})</span></p>
                </div>
            @endif

            <button type="submit" class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-sm transition-all">
                Submit Nilai
            </button>
        </form>
    </div>
</div>
@endsection