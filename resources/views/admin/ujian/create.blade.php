@extends("layouts.app")
@section("title","Jadwalkan Ujian")
@section("breadcrumb","Jadwalkan Ujian")

@section("content")
<div class="space-y-6">
    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Jadwalkan Ujian Skripsi</h1>
            <p class="mt-1 text-xs text-slate-500">Atur tanggal, waktu, dan ruangan pelaksanaan ujian/seminar</p>
        </div>
        <a href="{{ route('admin.ujian.index') }}" class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-bold text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 rounded-xl transition shadow-sm w-fit">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-slate-200">
        <form method="POST" action="{{ route('admin.ujian.store') }}" class="w-full space-y-5">
            @csrf
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Pilih Skripsi Mahasiswa <span class="text-rose-500">*</span></label>
                <select name="skripsi_id" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 rounded-xl text-sm font-medium transition" required>
                    <option value="">-- Pilih Skripsi --</option>
                    @foreach($skripsiList as $s)
                        <option value="{{ $s->id }}" {{ old('skripsi_id') == $s->id ? 'selected' : '' }}>{{ $s->mahasiswa?->nama }} - {{ $s->judul }}</option>
                    @endforeach
                </select>
                @error('skripsi_id') <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Tipe Ujian <span class="text-rose-500">*</span></label>
                    <select name="tipe" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 rounded-xl text-sm font-medium transition" required>
                        <option value="proposal" {{ old('tipe') == 'proposal' ? 'selected' : '' }}>Seminar Proposal</option>
                        <option value="hasil" {{ old('tipe') == 'hasil' ? 'selected' : '' }}>Seminar Hasil</option>
                        <option value="skripsi" {{ old('tipe') == 'skripsi' ? 'selected' : '' }}>Ujian Skripsi / Munaqasyah</option>
                    </select>
                    @error('tipe') <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Tanggal & Waktu Ujian <span class="text-rose-500">*</span></label>
                    <input type="datetime-local" name="jadwal" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 rounded-xl text-sm font-medium transition" required value="{{ old('jadwal') }}">
                    @error('jadwal') <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Tempat / Ruangan <span class="text-rose-500">*</span></label>
                    <input name="tempat" placeholder="Contoh: Ruang Seminar FT 01" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 rounded-xl text-sm font-medium transition" required value="{{ old('tempat') }}">
                    @error('tempat') <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-xl shadow-md shadow-emerald-600/20 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Jadwal
                </button>
                <a href="{{ route('admin.ujian.index') }}" class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-bold rounded-xl transition">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection