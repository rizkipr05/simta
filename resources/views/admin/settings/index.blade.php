@extends("layouts.app")
@section("title", "Pengaturan Sistem")
@section("breadcrumb", "Pengaturan")

@section("content")
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Pengaturan Sistem SIMTA</h1>
        <p class="text-xs text-slate-500 mt-1">Konfigurasi parameter akademik dan institusi UMMU</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 max-w-3xl">
        <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-5">
            @csrf
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Nama Institusi</label>
                <input name="nama_institusi" value="{{ $settings['nama_institusi'] ?? 'UNIVERSITAS MUHAMMADIYAH MALUKU UTARA' }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-900 focus:bg-white focus:ring-2 focus:ring-emerald-500">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Nama Fakultas</label>
                <input name="nama_fakultas" value="{{ $settings['nama_fakultas'] ?? 'FAKULTAS TEKNIK' }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-900 focus:bg-white focus:ring-2 focus:ring-emerald-500">
            </div>

            <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-md shadow-emerald-600/20 transition-all">Simpan Pengaturan</button>
        </form>
    </div>
</div>
@endsection