@extends("layouts.app")
@section("title", "Ajukan Bimbingan")
@section("breadcrumb", "Ajukan Bimbingan")

@section("content")
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Ajukan Sesi Bimbingan</h1>
            <p class="text-xs text-slate-500 mt-1">Pilih pembimbing, ajukan jadwal, tulis topik, unggah bukti, dan kirim permintaan bimbingan.</p>
        </div>
        <a href="{{ route('mahasiswa.bimbingan.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition-all">← Kembali ke Riwayat Bimbingan</a>
    </div>

    @if($skripsi)
    <div class="max-w-3xl bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
        <form method="POST" action="{{ route('mahasiswa.bimbingan.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Pilih Pembimbing *</label>
                <select name="dosen_id" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-900 focus:bg-white focus:ring-2 focus:ring-emerald-500">
                    @foreach($skripsi->pembimbing as $p)
                        <option value="{{ $p->dosen->id }}">Pembimbing {{ $p->jabatan }}: {{ $p->dosen->nama_lengkap }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Jadwal Bimbingan</label>
                    <input type="datetime-local" name="tanggal_bimbingan" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-900 focus:bg-white focus:ring-2 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Bab / Draf Bimbingan *</label>
                    <select name="bab_bimbingan" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-900 focus:bg-white focus:ring-2 focus:ring-emerald-500">
                        <option value="Bab I - Pendahuluan">Bab I - Pendahuluan</option>
                        <option value="Bab II - Tinjauan Pustaka">Bab II - Tinjauan Pustaka</option>
                        <option value="Bab III - Metodologi">Bab III - Metodologi</option>
                        <option value="Draft Proposal Lengkap">Draft Proposal Lengkap</option>
                        <option value="Bab IV - Hasil &amp; Pembahasan">Bab IV - Hasil &amp; Pembahasan</option>
                        <option value="Bab V - Penutup">Bab V - Penutup</option>
                        <option value="Draft Skripsi Final">Draft Skripsi Final</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Topik *</label>
                <input type="text" name="topik" required placeholder="Contoh: Revisi Bab 1 dan rumusan masalah" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-900 focus:bg-white focus:ring-2 focus:ring-emerald-500">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Catatan / Ringkasan *</label>
                <textarea name="catatan_mahasiswa" rows="4" required placeholder="Jelaskan bagian yang ingin dibahas dan kendala yang dihadapi..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-900 focus:bg-white focus:ring-2 focus:ring-emerald-500"></textarea>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">Upload Dokumen / Bukti Bimbingan</label>
                <input type="file" name="file_dokumen" accept="application/pdf,.doc,.docx" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-100 file:text-emerald-700">
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-md shadow-emerald-600/20 transition-all">Kirim Bimbingan</button>
                <a href="{{ route('mahasiswa.bimbingan.index') }}" class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs rounded-xl transition-all">Batal</a>
            </div>
        </form>
    </div>
    @else
    <div class="bg-white rounded-2xl border border-slate-200 p-8 text-center text-slate-500 font-semibold">
        Anda harus memiliki skripsi terdaftar terlebih dahulu untuk melakukan bimbingan.
    </div>
    @endif
</div>
@endsection