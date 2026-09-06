@extends("layouts.app")
@section("title", "Edit Mahasiswa")
@section("breadcrumb", "Edit Mahasiswa")

@section("content")
<div class="space-y-6">
    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Edit Data Mahasiswa</h1>
            <p class="mt-1 text-xs text-slate-500">Perbarui informasi profil dan data akademik mahasiswa</p>
        </div>
        <a href="{{ route('admin.master.mahasiswa.index') }}" class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-bold text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 rounded-xl transition shadow-sm w-fit">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-slate-200">
        <form method="POST" action="{{ route('admin.master.mahasiswa.update', $mahasiswa) }}" class="w-full space-y-5">
            @csrf
            @method("PUT")
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">NIM *</label>
                    <input name="nim" value="{{ old('nim', $mahasiswa->nim) }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 rounded-xl text-sm font-medium transition" required>
                    @error('nim') <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Nama Lengkap *</label>
                    <input name="nama" value="{{ old('nama', $mahasiswa->nama) }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 rounded-xl text-sm font-medium transition" required>
                    @error('nama') <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Program Studi *</label>
                <select name="prodi_id" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 rounded-xl text-sm font-medium transition" required>
                    @foreach($prodiList as $p)
                        <option value="{{ $p->id }}" {{ old('prodi_id', $mahasiswa->prodi_id) == $p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
                    @endforeach
                </select>
                @error('prodi_id') <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Angkatan</label>
                    <input name="angkatan" value="{{ old('angkatan', $mahasiswa->angkatan) }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 rounded-xl text-sm font-medium transition">
                    @error('angkatan') <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Semester *</label>
                    <input name="semester" type="number" min="1" max="14" value="{{ old('semester', $mahasiswa->semester) }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 rounded-xl text-sm font-medium transition" required>
                    @error('semester') <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Email *</label>
                    <input type="email" name="email" value="{{ old('email', $mahasiswa->email) }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 rounded-xl text-sm font-medium transition" required>
                    @error('email') <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">No. HP</label>
                    <input name="no_hp" value="{{ old('no_hp', $mahasiswa->no_hp) }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 rounded-xl text-sm font-medium transition">
                    @error('no_hp') <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-xl shadow-md shadow-emerald-600/20 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.master.mahasiswa.index') }}" class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-bold rounded-xl transition">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection