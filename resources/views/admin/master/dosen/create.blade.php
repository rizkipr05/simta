@extends("layouts.app")
@section("title","Tambah Dosen")
@section("breadcrumb","Tambah Dosen")

@section("content")
<div class="space-y-6">
    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Tambah Dosen</h1>
            <p class="mt-1 text-xs text-slate-500">Tambah data dosen baru ke dalam sistem SIMTA</p>
        </div>
        <a href="{{ route('admin.master.dosen.index') }}" class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-bold text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 rounded-xl transition shadow-sm w-fit">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-slate-200">
        <form method="POST" action="{{ route('admin.master.dosen.store') }}" class="w-full space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">NIDN <span class="text-rose-500">*</span></label>
                <input name="nidn" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 rounded-xl text-sm font-medium transition" required placeholder="Contoh: 0012058001" value="{{ old('nidn') }}">
                @error('nidn') <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Nama Lengkap <span class="text-rose-500">*</span></label>
                <input name="nama" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 rounded-xl text-sm font-medium transition" required placeholder="Nama tanpa gelar" value="{{ old('nama') }}">
                @error('nama') <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Gelar Depan</label>
                    <input name="gelar_depan" placeholder="Dr." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 rounded-xl text-sm font-medium transition" value="{{ old('gelar_depan') }}">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Gelar Belakang</label>
                    <input name="gelar_belakang" placeholder="M.T." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 rounded-xl text-sm font-medium transition" value="{{ old('gelar_belakang') }}">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Program Studi <span class="text-rose-500">*</span></label>
                <select name="prodi_id" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 rounded-xl text-sm font-medium transition" required>
                    <option value="">-- Pilih Program Studi --</option>
                    @foreach($prodiList as $p)
                        <option value="{{ $p->id }}" {{ old('prodi_id') == $p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
                    @endforeach
                </select>
                @error('prodi_id') <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Jabatan Fungsional</label>
                <input name="jabatan" placeholder="Lektor / Asisten Ahli / Guru Besar" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 rounded-xl text-sm font-medium transition" value="{{ old('jabatan') }}">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Email <span class="text-rose-500">*</span></label>
                <input type="email" name="email" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 rounded-xl text-sm font-medium transition" required placeholder="email@ummu.ac.id" value="{{ old('email') }}">
                @error('email') <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-xl shadow-md shadow-emerald-600/20 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan
                </button>
                <a href="{{ route('admin.master.dosen.index') }}" class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-bold rounded-xl transition">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection