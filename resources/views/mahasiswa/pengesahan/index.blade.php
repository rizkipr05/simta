@extends("layouts.app")
@section("title", "Upload Lembar Pengesahan")
@section("breadcrumb", "Upload Pengesahan")

@section("content")
<div class="space-y-8">
    {{-- Header Banner --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Upload Lembar Pengesahan (TTD Basah)</h1>
            <p class="text-xs text-slate-500 mt-1">Unggah dokumen hasil scan lembar pengesahan bertanda tangan basah setelah lulus sidang skripsi</p>
        </div>
        <a href="{{ route('mahasiswa.dashboard') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition-all">
            &larr; Kembali ke Dashboard
        </a>
    </div>
    @if($skripsi)
        <!-- Form Card -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-6">
            <div class="border-b border-slate-200 px-5 py-4 bg-slate-50/50 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h2 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider">Formulir Upload Lembar Pengesahan</h2>
                    <p class="text-xs text-slate-500">Persyaratan verifikasi akhir sebelum pendaftaran yudisium</p>
                </div>
            </div>

            <div class="p-5">
                <div class="p-4 bg-blue-50 border border-blue-200 rounded-xl mb-5">
                    <p class="text-xs font-extrabold text-blue-900 uppercase tracking-wider">Petunjuk Pengunggahan:</p>
                    <ul class="list-disc list-inside mt-2 text-xs text-blue-800 space-y-1 font-medium">
                        <li>Pastikan lembar pengesahan telah ditandatangani basah oleh Pembimbing, Penguji, dan Dekan.</li>
                        <li>Format berkas wajib PDF atau JPG/PNG resolusi tinggi (maks 10 MB).</li>
                    </ul>
                </div>

                @if ($errors->any())
                    <div class="mb-5 rounded-xl bg-rose-50 p-4 border border-rose-200 shadow-sm">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-8 h-8 rounded-lg bg-rose-100 flex items-center justify-center text-rose-600">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <h3 class="text-sm font-extrabold text-rose-800 tracking-tight">Ups, Gagal Mengunggah Berkas!</h3>
                        </div>
                        <ul class="list-inside list-disc text-xs font-semibold text-rose-700 space-y-1 ml-11">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                <form method="POST" action="{{ route('mahasiswa.upload.pengesahan', $skripsi) }}" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-[1fr,auto] gap-4 items-end">
                    @csrf
                    <div class="space-y-2">
                        <label class="block text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">Pilih File Lembar Pengesahan *</label>
                        <input type="file" name="file_pengesahan" accept="application/pdf,image/*" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-0 file:text-[10px] file:font-extrabold file:uppercase file:tracking-wider file:bg-emerald-100 file:text-emerald-700 hover:file:bg-emerald-200 cursor-pointer" required>
                    </div>
                    <div>
                        <button type="submit" class="w-full px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-md shadow-emerald-600/20 transition-all flex items-center justify-center gap-2 h-[45px]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            Unggah Berkas Sekarang
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table Data Card -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="border-b border-slate-200 px-5 py-4 bg-slate-50/50">
                <h2 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider">Status Lembar Pengesahan Terunggah</h2>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-200">
                            <th class="px-5 py-4 text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">TANGGAL UNGGAH</th>
                            <th class="px-5 py-4 text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">DOKUMEN FILE</th>
                            <th class="px-5 py-4 text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">STATUS VERIFIKASI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @if($skripsi->lembarPengesahan)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-5 py-4 align-middle whitespace-nowrap">
                                <span class="text-xs font-bold text-slate-700">{{ $skripsi->lembarPengesahan->created_at ? $skripsi->lembarPengesahan->created_at->format('d M Y') : '-' }}</span>
                                <br>
                                <span class="text-[10px] font-semibold text-slate-400">{{ $skripsi->lembarPengesahan->created_at ? $skripsi->lembarPengesahan->created_at->format('H:i') : '-' }}</span>
                            </td>
                            <td class="px-5 py-4 align-middle">
                                @if($skripsi->lembarPengesahan->file_scan)
                                    <a href="{{ Storage::url($skripsi->lembarPengesahan->file_scan) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-100 hover:bg-blue-200 text-blue-700 font-bold text-[10px] uppercase tracking-wider rounded-lg border border-blue-200 transition-colors cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                        Buka File Scanner
                                    </a>
                                @else
                                    <span class="text-xs text-slate-400 italic">File tidak ada</span>
                                @endif
                                
                                @if($skripsi->lembarPengesahan->catatan)
                                    <div class="mt-2 text-[10px] font-semibold text-rose-600 bg-rose-50 px-2.5 py-1.5 rounded-lg border border-rose-100">
                                        <strong>Catatan:</strong> {{ $skripsi->lembarPengesahan->catatan }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-5 py-4 align-middle whitespace-nowrap">
                                @php
                                    $status = strtolower($skripsi->lembarPengesahan->status ?? 'menunggu_verifikasi');
                                    $statusClass = 'bg-slate-100 text-slate-700 border-slate-200';
                                    if (in_array($status, ['disetujui', 'approved', 'diterima'])) $statusClass = 'bg-emerald-100 text-emerald-800 border-emerald-200';
                                    elseif (in_array($status, ['ditolak', 'revisi', 'rejected'])) $statusClass = 'bg-rose-100 text-rose-800 border-rose-200';
                                    elseif (in_array($status, ['menunggu_verifikasi', 'pending'])) $statusClass = 'bg-amber-100 text-amber-800 border-amber-200';
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border {{ $statusClass }}">
                                    {{ str_replace('_', ' ', $status) }}
                                </span>
                            </td>
                        </tr>
                        @else
                        <tr>
                            <td colspan="3" class="px-5 py-10 text-center">
                                <div class="w-12 h-12 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-2">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <p class="text-xs font-bold text-slate-600">Belum Ada Dokumen</p>
                                <p class="text-[10px] text-slate-400 mt-0.5">Silakan unggah lembar pengesahan Anda melalui form di atas.</p>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        @else
            <div class="text-center py-8 text-slate-500 text-xs">
                Anda belum memiliki pengajuan skripsi aktif. Silakan ajukan judul skripsi terlebih dahulu.
            </div>
        @endif
    </div>
</div>
@endsection
