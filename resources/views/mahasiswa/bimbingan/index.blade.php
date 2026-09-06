@extends("layouts.app")
@section("title", "Bimbingan Skripsi")
@section("breadcrumb", "Bimbingan Skripsi")

@section("content")
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Bimbingan Skripsi</h1>
            <p class="text-xs text-slate-500 mt-1">Pilih pembimbing, ajukan jadwal, tulis topik, unggah bukti, dan pantau status persetujuan.</p>
        </div>
    </div>

    @if($skripsi)
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-extrabold text-slate-900">Riwayat Bimbingan &amp; Status Persetujuan</h2>
                <p class="text-xs text-slate-500 mt-1">Lihat history bimbingan Anda. Untuk mengajukan sesi baru, gunakan tombol di kanan.</p>
            </div>
            <a href="{{ route('mahasiswa.bimbingan.create') }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-xl shadow-md transition-all">Ajukan Sesi Bimbingan</a>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm">
            <div class="border-b border-slate-200 px-5 py-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-extrabold text-slate-900">Riwayat Bimbingan</h3>
                    <a href="{{ route('mahasiswa.bimbingan.create') }}" class="text-emerald-600 font-bold text-sm">Ajukan Sesi Baru</a>
                </div>
            </div>
            <div class="p-5 space-y-4">
                @forelse($bimbinganList as $b)
                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5 group hover:border-slate-300 transition-colors">
                    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-2">
                        <div>
                            <p class="text-sm font-extrabold text-slate-900">{{ $b->topik }}</p>
                            <p class="text-[11px] font-semibold text-slate-500 mt-1">{{ $b->tanggal_bimbingan ? $b->tanggal_bimbingan->translatedFormat('d M Y, H:i') : '-' }} · {{ $b->bab_bimbingan }}</p>
                        </div>
                        <span class="inline-flex px-3 py-1 rounded-full text-[10px] font-bold tracking-wide {{ $b->status === 'approved' ? 'bg-emerald-100 text-emerald-700' : ($b->status === 'revision' ? 'bg-rose-100 text-rose-700' : 'bg-amber-100 text-amber-700') }}">{{ ucfirst($b->status) }}</span>
                    </div>
                    
                    <div class="mt-4 space-y-2">
                        <p class="text-sm text-slate-700"><span class="font-bold text-slate-900">Dosen:</span> {{ $b->dosen->nama_lengkap ?? '-' }}</p>
                        <p class="text-sm text-slate-700"><span class="font-bold text-slate-900">Catatan mahasiswa:</span> {{ $b->catatan_mahasiswa ?? '-' }}</p>
                        <p class="text-sm text-slate-700"><span class="font-bold text-slate-900">Catatan dosen:</span> {{ $b->catatan_dosen ?? '-' }}</p>
                    </div>

                    @if($b->file_dokumen)
                        <div class="mt-4 flex flex-wrap items-center gap-3 border-t border-slate-200/60 pt-4">
                            <a href="{{ Storage::url($b->file_dokumen) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-100/50 hover:bg-blue-100 text-blue-700 text-[11px] font-bold rounded-xl transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                Bukti Bimbingan
                            </a>
                        </div>
                    @endif
                </div>
                @empty
                <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 p-10 text-center">
                    <p class="text-sm font-medium text-slate-500">Belum ada histori bimbingan.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
    @else
    <div class="bg-white rounded-2xl border border-slate-200 p-8 text-center text-slate-500 font-semibold">
        Anda harus memiliki skripsi terdaftar terlebih dahulu untuk melakukan bimbingan.
    </div>
    @endif
</div>
@endsection
