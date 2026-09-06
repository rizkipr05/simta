@extends("layouts.app")
@section("title", "Dokumen Skripsi Saya")
@section("breadcrumb", "Dokumen Skripsi")

@section("content")
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Dokumen Skripsi &amp; Versioning</h1>
            <p class="text-xs text-slate-500 mt-1">Unggah draf proposal, draf skripsi final, revisi, dan berkas lampiran penelitian Anda.</p>
        </div>
    </div>

    @if($skripsi)
    <!-- Section Upload Form -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm">
        <div class="border-b border-slate-200 px-5 py-4 bg-slate-50/50">
            <h2 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider">Unggah Dokumen Baru</h2>
        </div>
        <div class="p-5">
            <form method="POST" action="{{ route('mahasiswa.dokumen.store') }}" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-3 gap-5 items-end">
                @csrf
                <div class="space-y-2">
                    <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">Jenis Dokumen *</label>
                    <select name="jenis" required class="w-full px-3.5 py-2 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none bg-slate-50 text-slate-800 text-sm font-semibold">
                        <option value="draft_proposal">Draft Proposal Skripsi</option>
                        <option value="draft_skripsi">Draft Skripsi Final</option>
                        <option value="revisi_skripsi">Berkas Revisi Ujian</option>
                        <option value="lampiran_penelitian">Lampiran &amp; Data Penelitian</option>
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">Nama / Judul Berkas *</label>
                    <input type="text" name="nama" required placeholder="Contoh: Draf Proposal Rev-2 SIMTA" class="w-full px-3.5 py-2 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none bg-slate-50 text-slate-800 text-sm font-semibold">
                </div>
                <div class="space-y-2">
                    <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">Pilih File (PDF/DOC, Max 15MB) *</label>
                    <input type="file" name="file_dokumen" accept="application/pdf,.doc,.docx" required class="block w-full text-xs text-slate-500 file:mr-2 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-[10px] file:font-extrabold file:uppercase file:tracking-wider file:bg-emerald-100 file:text-emerald-700 hover:file:bg-emerald-200 transition-colors cursor-pointer">
                </div>
                <div class="md:col-span-3 flex justify-end mt-2 md:mt-0 pt-4 border-t border-slate-100">
                    <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-md shadow-emerald-600/20 transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        Unggah Dokumen Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Section Tabel Riwayat -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="border-b border-slate-200 px-5 py-4 bg-slate-50/50 flex flex-col md:flex-row md:items-center justify-between gap-3">
            <h2 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider">Riwayat Dokumen Terunggah</h2>
            <div class="text-[11px] font-bold text-slate-500 bg-white border border-slate-200 px-3 py-1.5 rounded-lg shadow-sm">
                Total Dokumen: {{ $dokumenList->count() }}
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200">
                        <th class="px-5 py-4 text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">JENIS DOKUMEN</th>
                        <th class="px-5 py-4 text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">NAMA BERKAS</th>
                        <th class="px-5 py-4 text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">TANGGAL UPLOAD</th>
                        <th class="px-5 py-4 text-[10px] font-extrabold text-slate-500 uppercase tracking-wider text-right">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($dokumenList as $d)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-5 py-4 align-middle whitespace-nowrap">
                            <span class="inline-flex px-3 py-1.5 bg-indigo-50 border border-indigo-100 text-indigo-700 font-extrabold text-[10px] uppercase tracking-wider rounded-lg shadow-sm">
                                {{ str_replace('_', ' ', $d->jenis) }}
                            </span>
                        </td>
                        <td class="px-5 py-4 align-middle">
                            <p class="font-bold text-slate-900 text-sm">{{ $d->nama }}</p>
                            <p class="text-[11px] font-semibold text-slate-500 mt-1">Ukuran: {{ number_format(($d->file_size ?? 0)/1024, 1) }} KB</p>
                        </td>
                        <td class="px-5 py-4 align-middle whitespace-nowrap">
                            <span class="text-xs font-bold text-slate-700">{{ $d->created_at ? $d->created_at->format('d M Y') : '-' }}</span>
                            <br>
                            <span class="text-[10px] font-semibold text-slate-400">{{ $d->created_at ? $d->created_at->format('H:i') : '-' }}</span>
                        </td>
                        <td class="px-5 py-4 align-middle text-right whitespace-nowrap">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ Storage::url($d->file_path) }}" target="_blank" class="px-3 py-1.5 bg-blue-100 hover:bg-blue-200 text-blue-700 font-bold text-[10px] uppercase tracking-wider rounded-lg border border-blue-200 transition-colors flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                    Cek File
                                </a>
                                <form method="POST" action="{{ route('mahasiswa.dokumen.destroy', $d) }}" onsubmit="return confirm('Yakin ingin menghapus dokumen ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 bg-rose-100 hover:bg-rose-200 text-rose-700 font-bold text-[10px] uppercase tracking-wider rounded-lg border border-rose-200 transition-colors flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-5 py-12 text-center">
                            <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <p class="text-sm font-bold text-slate-600">Belum Ada Dokumen Terunggah</p>
                            <p class="text-xs text-slate-400 mt-1">Dokumen proposal, bab, maupun lampiran akan tampil dalam tabel ini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="bg-white rounded-2xl border border-slate-200 p-8 text-center text-slate-500 font-semibold">
        Anda belum memiliki skripsi terdaftar.
    </div>
    @endif
</div>
@endsection
