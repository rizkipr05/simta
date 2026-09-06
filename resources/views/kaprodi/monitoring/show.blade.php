@extends("layouts.app")
@section("title", "Detail Monitoring Mahasiswa")
@section("breadcrumb", "Detail Mahasiswa")

@section("content")
<div class="space-y-6">
    <div class="flex items-center justify-between gap-3">
        <a href="{{ route('kaprodi.monitoring.index') }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-900">← Kembali ke Monitoring</a>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Mahasiswa</p>
                <h1 class="mt-1 text-2xl font-black text-slate-900">{{ $mahasiswa->nama }} <span class="text-base font-semibold text-slate-500">(NIM: {{ $mahasiswa->nim }})</span></h1>
            </div>
            <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-[10px] font-bold uppercase text-emerald-800">{{ $mahasiswa->status_label }}</span>
        </div>

        <div class="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-xl bg-slate-50 p-4">
                <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Progress</p>
                <p class="mt-2 text-2xl font-black text-slate-900">{{ $mahasiswa->progress ?? 0 }}%</p>
            </div>
            <div class="rounded-xl bg-slate-50 p-4">
                <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Jumlah Bimbingan</p>
                <p class="mt-2 text-2xl font-black text-slate-900">{{ $mahasiswa->bimbingan_count ?? 0 }}</p>
            </div>
            <div class="rounded-xl bg-slate-50 p-4">
                <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Status Revisi</p>
                <p class="mt-2 text-2xl font-black text-slate-900">{{ $mahasiswa->revisi_count ?? 0 }}</p>
            </div>
            <div class="rounded-xl bg-slate-50 p-4">
                <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Lama Pengerjaan</p>
                <p class="mt-2 text-2xl font-black text-slate-900">{{ $mahasiswa->days_since_start ?? 0 }} hari</p>
            </div>
        </div>

        @if($mahasiswa->skripsi)
            <div class="mt-6 grid gap-6 xl:grid-cols-2">
                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Judul Skripsi</p>
                    <h2 class="mt-2 text-lg font-extrabold text-slate-900">{{ $mahasiswa->skripsi->judul }}</h2>
                    <div class="mt-4 space-y-2 text-sm text-slate-600">
                        <p><span class="font-bold text-slate-800">Pembimbing:</span> {{ $mahasiswa->skripsi->pembimbing1?->dosen?->nama ?? '-' }}</p>
                        <p><span class="font-bold text-slate-800">Status:</span> {{ ucfirst($mahasiswa->skripsi->status) }}</p>
                        <p><span class="font-bold text-slate-800">Tanggal Mulai:</span> {{ $mahasiswa->skripsi->tanggal_mulai?->format('d M Y') ?? '-' }}</p>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">Detail Perjalanan Skripsi</p>
                    <div class="mt-4 space-y-3 text-sm text-slate-600">
                        <div class="flex items-center justify-between rounded-xl bg-white p-3">
                            <span>Ujian</span>
                            <span class="font-bold text-slate-900">{{ $mahasiswa->skripsi->ujian ? 'Terjadwal' : 'Belum' }}</span>
                        </div>
                        <div class="flex items-center justify-between rounded-xl bg-white p-3">
                            <span>Berita Acara</span>
                            <span class="font-bold text-slate-900">{{ $mahasiswa->skripsi->beritaAcara ? 'Ada' : 'Belum' }}</span>
                        </div>
                        <div class="flex items-center justify-between rounded-xl bg-white p-3">
                            <span>Lembar Pengesahan</span>
                            <span class="font-bold text-slate-900">{{ $mahasiswa->skripsi->lembarPengesahan ? 'Lengkap' : 'Belum' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
