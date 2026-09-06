@extends("layouts.app")
@section("title", "Notifikasi & Pengumuman")
@section("breadcrumb", "Notifikasi")

@section("content")
<div class="space-y-8">
    {{-- Header Banner --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Pusat Notifikasi &amp; Pengumuman</h1>
            <p class="text-xs text-slate-500 mt-1">Pemberitahuan real-time terkait aktivitas bimbingan, verifikasi berkas, dan jadwal UMMU</p>
        </div>
        <a href="{{ route('mahasiswa.dashboard') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition-all">
            &larr; Kembali ke Dashboard
        </a>
    </div>

    {{-- Notification Center List --}}
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm space-y-6">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 01-6 0v-1m6 0H9"/></svg>
                </div>
                <div>
                    <h2 class="font-extrabold text-slate-900 text-base">Kotak Masuk Notifikasi</h2>
                    <p class="text-xs text-slate-500">Pemberitahuan aktivitas akademik terbaru</p>
                </div>
            </div>
            <form method="POST" action="{{ route('mahasiswa.notifikasi.read-all') }}">
                @csrf
                <button type="submit" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition-all">
                    Tandai Semua Dibaca
                </button>
            </form>
        </div>

        <div class="space-y-3">
            {{-- Default System Status --}}
            <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-start gap-3">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 mt-1.5 flex-shrink-0"></span>
                <div class="flex-1">
                    <p class="text-xs font-bold text-emerald-900">Sistem SIMTA Berjalan Normal</p>
                    <p class="text-xs text-emerald-700 mt-0.5">Seluruh layanan pengajuan judul, bimbingan, upload dokumen, hingga pendaftaran yudisium siap digunakan.</p>
                    <span class="text-[10px] text-emerald-600 mt-1 block">Hari ini</span>
                </div>
            </div>

            @forelse($notifikasiList as $n)
                <div class="p-4 rounded-xl border flex items-start justify-between gap-3 {{ $n->is_read ? 'bg-slate-50 border-slate-200' : 'bg-amber-50 border-amber-200' }}">
                    <div class="flex items-start gap-3">
                        <span class="w-2.5 h-2.5 rounded-full mt-1.5 flex-shrink-0 {{ $n->is_read ? 'bg-slate-400' : 'bg-amber-500' }}"></span>
                        <div>
                            <h3 class="text-xs font-bold text-slate-900">{{ $n->judul }}</h3>
                            <p class="text-xs text-slate-600 mt-0.5">{{ $n->pesan }}</p>
                            <span class="text-[10px] text-slate-400 mt-1 block">{{ $n->created_at ? $n->created_at->diffForHumans() : '-' }}</span>
                        </div>
                    </div>
                    @if(!$n->is_read)
                        <form method="POST" action="{{ route('mahasiswa.notifikasi.read', $n) }}">
                            @csrf
                            <button type="submit" class="px-2.5 py-1 bg-white border border-amber-300 hover:bg-amber-100 text-amber-900 font-bold text-[10px] rounded-lg shadow-2xs">
                                Tandai Dibaca
                            </button>
                        </form>
                    @endif
                </div>
            @empty
                {{-- Additional helpful status --}}
                <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl flex items-start gap-3 text-xs text-slate-600">
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-500 mt-1.5 flex-shrink-0"></span>
                    <div>
                        <p class="font-bold text-slate-900">Selamat Datang di SIMTA Portal Mahasiswa</p>
                        <p class="text-slate-500 mt-0.5">Pemberitahuan terkini dari Dosen Pembimbing dan Kaprodi akan langsung muncul di halaman notifikasi ini.</p>
                    </div>
                </div>
            @endforelse
        </div>

        @if($notifikasiList->hasPages())
            <div class="pt-2">
                {{ $notifikasiList->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
