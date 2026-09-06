@extends("layouts.app")
@section("title", "Tambah Tahun Akademik")
@section("breadcrumb", "Tambah Tahun Akademik")

@section("content")
<div class="space-y-6">
    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Tambah Tahun Akademik</h1>
            <p class="mt-1 text-xs text-slate-500">Buat periode tahun akademik baru untuk sistem SIMTA</p>
        </div>
        <a href="{{ route('admin.master.tahun-akademik.index') }}" class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-bold text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 rounded-xl transition shadow-sm w-fit">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-slate-200">
        <form method="POST" action="{{ route('admin.master.tahun-akademik.store') }}" class="w-full space-y-5">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Tahun (contoh: 2025/2026) <span class="text-rose-500">*</span></label>
                    <input type="text" name="tahun" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 rounded-xl text-sm font-medium transition" required placeholder="2025/2026" value="{{ old('tahun') }}">
                    @error('tahun') <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Semester <span class="text-rose-500">*</span></label>
                    <select name="semester" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 rounded-xl text-sm font-medium transition" required>
                        <option value="ganjil" {{ old('semester') == 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                        <option value="genap" {{ old('semester') == 'genap' ? 'selected' : '' }}>Genap</option>
                    </select>
                    @error('semester') <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="pt-2">
                <label class="flex items-center gap-3 w-full p-3.5 bg-slate-50 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-100/80 transition">
                    <input type="checkbox" name="is_aktif" id="is_aktif" value="1" class="w-4 h-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500" {{ old('is_aktif') ? 'checked' : '' }}>
                    <span class="text-xs font-bold text-slate-700 select-none">Set sebagai Tahun Akademik Aktif</span>
                </label>
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-xl shadow-md shadow-emerald-600/20 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan
                </button>
                <a href="{{ route('admin.master.tahun-akademik.index') }}" class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-bold rounded-xl transition">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection