@extends("layouts.app")
@section("title", "Laporan Rekapitulasi")
@section("breadcrumb", "Laporan")

@section("content")
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Laporan Rekapitulasi Akademik</h1>
            <p class="text-xs text-slate-500 mt-1">Unduh rekapitulasi data skripsi, penguji, dan yudisium Fakultas Teknik UMMU</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <div>
                <h3 class="font-bold text-slate-900 text-base">Rekap Skripsi Mahasiswa</h3>
                <p class="text-xs text-slate-500 mt-1">Laporan rekapitulasi alur status skripsi seluruh program studi.</p>
            </div>
            <a href="{{ route('admin.laporan.rekap-skripsi') }}" class="block w-full text-center py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-sm transition-all">Unduh Laporan PDF</a>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
            <div class="w-12 h-12 rounded-xl bg-teal-100 text-teal-700 flex items-center justify-center font-bold">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
            <div>
                <h3 class="font-bold text-slate-900 text-base">Rekap Yudisium &amp; Kelulusan</h3>
                <p class="text-xs text-slate-500 mt-1">Daftar lulusan yang telah diverifikasi dan disahkan.</p>
            </div>
            <a href="{{ route('admin.laporan.rekap-yudisium') }}" class="block w-full text-center py-2.5 bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs rounded-xl shadow-sm transition-all">Unduh Laporan PDF</a>
        </div>
    </div>
</div>
@endsection