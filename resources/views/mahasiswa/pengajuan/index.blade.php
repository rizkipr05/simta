@extends("layouts.app")
@section("title", "Pengajuan Judul Skripsi")
@section("breadcrumb", "Pengajuan Judul")

@section("content")
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Pengajuan Judul Skripsi</h1>
            <p class="text-xs text-slate-500 mt-1">Ajukan judul, lengkapi proposal, dan pantau status persetujuan dari prodi atau admin.</p>
        </div>
        <a href="{{ route('mahasiswa.dashboard') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition-all">
            ← Kembali ke Dashboard
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm">
        <div class="border-b border-slate-200 px-5 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-lg font-extrabold text-slate-900">Form Judul Skripsi</h2>
                <p class="text-xs text-slate-500 mt-0.5">Isi proposal awal secara lengkap agar persetujuan lebih cepat.</p>
            </div>
            @if($skripsi)
                <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-[10px] font-bold uppercase text-emerald-800 border border-emerald-200">
                    {{ str_replace('_', ' ', $skripsi->status) }}
                </span>
            @endif
        </div>

        <div class="p-5">
            @if(!$skripsi)
                <form method="POST" action="{{ route('mahasiswa.pengajuan.store') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Judul Skripsi *</label>
                        <textarea name="judul" rows="2" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm" required placeholder="Tuliskan judul skripsi yang diajukan..."></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Bidang Penelitian</label>
                            <input name="bidang_penelitian" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm" placeholder="Contoh: AI, IoT, Sistem Informasi, Rekayasa Perangkat Lunak">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Metode</label>
                            <input name="metode" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm" placeholder="Contoh: Waterfall, Agile, R&D, Survey, Eksperimen">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Latar Belakang</label>
                        <textarea name="latar_belakang" rows="4" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm" placeholder="Jelaskan alasan dan konteks penelitian..."></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Rumusan Masalah</label>
                        <textarea name="rumusan_masalah" rows="3" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm" placeholder="Tuliskan pertanyaan utama yang ingin dijawab..."></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Tujuan Penelitian</label>
                        <textarea name="tujuan" rows="3" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm" placeholder="Tujuan umum dan khusus dari penelitian..."></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Upload Proposal</label>
                        <input type="file" name="proposal_file" accept="application/pdf,.doc,.docx" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-100 file:text-emerald-700">
                    </div>

                    <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-md shadow-emerald-600/20 transition-all">
                        Kirim Pengajuan Judul
                    </button>
                </form>
            @else
                <div class="space-y-4">
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-5">
                        <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Judul Skripsi Terdaftar</p>
                        <p class="mt-2 text-base font-extrabold text-slate-900">{{ $skripsi->judul }}</p>
                        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-3 text-xs text-slate-600 font-semibold pt-3 border-t border-slate-200">
                            <span>Bidang: {{ $skripsi->bidang_kajian ?: '-' }}</span>
                            <span>Tanggal Pengajuan: {{ $skripsi->created_at ? $skripsi->created_at->format('d M Y, H:i') : '-' }}</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                            <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Latar Belakang</p>
                            <p class="mt-2 text-sm text-slate-700">{{ $skripsi->deskripsi ?: 'Belum ada detail latar belakang yang diisi.' }}</p>
                        </div>
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                            <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Status Pengajuan</p>
                            <p class="mt-2 text-sm text-slate-700">{{ str_replace('_', ' ', $skripsi->status) }}</p>
                        </div>
                    </div>

                    @if($skripsi->catatan_penolakan)
                        <div class="rounded-xl border border-rose-200 bg-rose-50 p-4 text-xs shadow-sm">
                            <p class="font-bold text-rose-800 uppercase tracking-wider">Catatan Penolakan / Revisi</p>
                            <p class="mt-1 font-medium text-rose-700">{{ $skripsi->catatan_penolakan }}</p>
                        </div>
                    @endif

                    <div class="pt-6 mt-4 border-t border-slate-200 flex flex-wrap items-center gap-3">
                        @if($skripsi->status === 'pengajuan')
                            <!-- Tombol Batalkan Pengajuan -->
                            <form method="POST" action="{{ route('mahasiswa.pengajuan.destroy', $skripsi) }}" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pengajuan judul skripsi ini? Anda harus mengisi form pengajuan dari awal lagi nanti.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-xl shadow-sm shadow-rose-500/20 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Batalkan Pengajuan
                                </button>
                            </form>
                        @endif

                        @if(in_array($skripsi->status, ['aktif', 'revisi_proposal', 'siap_sidang']))
                            <a href="{{ route('mahasiswa.bimbingan.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-sm shadow-emerald-500/20 transition-all">
                                Lanjut ke Bimbingan
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        @endif

                        <a href="{{ route('mahasiswa.pengajuan.show', $skripsi) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-sm shadow-blue-500/20 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            Detail Pengajuan
                        </a>
                    </div>

                </div>
            @endif
        </div>
    </div>
</div>
@endsection