@php $role = auth()->user()->role; @endphp

@php
$isAdmin = in_array($role, ['super_admin', 'pengelola_skripsi']);
$isDekan = $role === 'dekan';
$isKaprodi = $role === 'kaprodi';
$isDosen = $role === 'dosen';
$isMahasiswa = $role === 'mahasiswa';

$iconDashboard = '<svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 011-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>';
$iconUsers = '<svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>';
$iconDoc = '<svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>';
$iconCalendar = '<svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>';
$iconCheck = '<svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
$iconMonitor = '<svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>';
$iconFolder = '<svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>';
$iconAward = '<svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>';
$iconSetting = '<svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>';
$iconBell = '<svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 01-6 0v-1m6 0H9"/></svg>';
@endphp

@if($isAdmin)
    <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }} flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-300 hover:text-white text-sm font-semibold transition-all">
        {!! $iconDashboard !!}<span x-show="sidebarOpen" x-transition class="truncate">Dashboard</span>
    </a>

    <div x-show="sidebarOpen" class="px-3 pt-4 pb-1.5">
        <p class="text-[11px] font-bold text-emerald-400 uppercase tracking-widest">Master Data &amp; User</p>
    </div>
    <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users*') ? 'active' : '' }} flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-300 hover:text-white text-sm font-semibold transition-all">
        {!! $iconUsers !!}<span x-show="sidebarOpen" x-transition class="truncate">Manajemen User &amp; Role</span>
    </a>
    <a href="{{ route('admin.master.dosen.index') }}" class="sidebar-link {{ request()->routeIs('admin.master.dosen*') ? 'active' : '' }} flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-300 hover:text-white text-sm font-semibold transition-all">
        {!! $iconUsers !!}<span x-show="sidebarOpen" x-transition class="truncate">Master Data Dosen</span>
    </a>
    <a href="{{ route('admin.master.mahasiswa.index') }}" class="sidebar-link {{ request()->routeIs('admin.master.mahasiswa*') ? 'active' : '' }} flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-300 hover:text-white text-sm font-semibold transition-all">
        {!! $iconFolder !!}<span x-show="sidebarOpen" x-transition class="truncate">Master Data Mahasiswa</span>
    </a>
    <a href="{{ route('admin.master.program-studi.index') }}" class="sidebar-link {{ request()->routeIs('admin.master.program-studi*') ? 'active' : '' }} flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-300 hover:text-white text-sm font-semibold transition-all">
        {!! $iconFolder !!}<span x-show="sidebarOpen" x-transition class="truncate">Program Studi</span>
    </a>
    <a href="{{ route('admin.master.tahun-akademik.index') }}" class="sidebar-link {{ request()->routeIs('admin.master.tahun-akademik*') ? 'active' : '' }} flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-300 hover:text-white text-sm font-semibold transition-all">
        {!! $iconCalendar !!}<span x-show="sidebarOpen" x-transition class="truncate">Tahun Akademik</span>
    </a>

    <div x-show="sidebarOpen" class="px-3 pt-4 pb-1.5">
        <p class="text-[11px] font-bold text-emerald-400 uppercase tracking-widest">Pengelolaan Skripsi</p>
    </div>
    <a href="{{ route('admin.skripsi.index') }}" class="sidebar-link {{ request()->routeIs('admin.skripsi.index') ? 'active' : '' }} flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-300 hover:text-white text-sm font-semibold transition-all">
        {!! $iconDoc !!}<span x-show="sidebarOpen" x-transition class="truncate">Pengelolaan Skripsi</span>
    </a>
    <a href="{{ route('admin.sk-pembimbing.index') }}" class="sidebar-link {{ request()->routeIs('admin.sk-pembimbing*') ? 'active' : '' }} flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-300 hover:text-white text-sm font-semibold transition-all">
        {!! $iconDoc !!}<span x-show="sidebarOpen" x-transition class="truncate">Penetapan &amp; SK Pembimbing</span>
    </a>
    <a href="{{ route('admin.ujian.index') }}" class="sidebar-link {{ request()->routeIs('admin.ujian*') ? 'active' : '' }} flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-300 hover:text-white text-sm font-semibold transition-all">
        {!! $iconCalendar !!}<span x-show="sidebarOpen" x-transition class="truncate">Jadwal &amp; SK Penguji</span>
    </a>
    <a href="{{ route('admin.berita-acara.index') }}" class="sidebar-link {{ request()->routeIs('admin.berita-acara*') ? 'active' : '' }} flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-300 hover:text-white text-sm font-semibold transition-all">
        {!! $iconDoc !!}<span x-show="sidebarOpen" x-transition class="truncate">Berita Acara Ujian</span>
    </a>
    <a href="{{ route('admin.pengesahan.index') }}" class="sidebar-link {{ request()->routeIs('admin.pengesahan*') ? 'active' : '' }} flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-300 hover:text-white text-sm font-semibold transition-all">
        {!! $iconCheck !!}<span x-show="sidebarOpen" x-transition class="truncate">Verifikasi Pengesahan</span>
    </a>

    <div x-show="sidebarOpen" class="px-3 pt-4 pb-1.5">
        <p class="text-[11px] font-bold text-emerald-400 uppercase tracking-widest">Yudisium &amp; Repository</p>
    </div>
    <a href="{{ route('admin.yudisium.index') }}" class="sidebar-link {{ request()->routeIs('admin.yudisium*') ? 'active' : '' }} flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-300 hover:text-white text-sm font-semibold transition-all">
        {!! $iconAward !!}<span x-show="sidebarOpen" x-transition class="truncate">Yudisium</span>
    </a>
    <a href="{{ route('admin.dokumen.index') }}" class="sidebar-link {{ request()->routeIs('admin.dokumen*') ? 'active' : '' }} flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-300 hover:text-white text-sm font-semibold transition-all">
        {!! $iconFolder !!}<span x-show="sidebarOpen" x-transition class="truncate">Repository Dokumen</span>
    </a>
    <a href="{{ route('admin.laporan.index') }}" class="sidebar-link {{ request()->routeIs('admin.laporan.index') ? 'active' : '' }} flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-300 hover:text-white text-sm font-semibold transition-all">
        {!! $iconMonitor !!}<span x-show="sidebarOpen" x-transition class="truncate">Laporan Rekapitulasi</span>
    </a>
    <a href="{{ route('admin.audit-log.index') }}" class="sidebar-link {{ request()->routeIs('admin.audit-log*') ? 'active' : '' }} flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-300 hover:text-white text-sm font-semibold transition-all">
        {!! $iconMonitor !!}<span x-show="sidebarOpen" x-transition class="truncate">Audit Log</span>
    </a>
    @if($role === 'super_admin')
    <a href="{{ route('admin.settings.index') }}" class="sidebar-link {{ request()->routeIs('admin.settings*') ? 'active' : '' }} flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-300 hover:text-white text-sm font-semibold transition-all">
        {!! $iconSetting !!}<span x-show="sidebarOpen" x-transition class="truncate">Pengaturan Sistem</span>
    </a>
    @endif

@elseif($isKaprodi)
    <a href="{{ route('kaprodi.dashboard') }}" class="sidebar-link {{ request()->routeIs('kaprodi.dashboard') ? 'active' : '' }} flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-300 hover:text-white text-sm font-semibold transition-all">
        {!! $iconDashboard !!}<span x-show="sidebarOpen" x-transition class="truncate">Dashboard &amp; Statistik</span>
    </a>
    <div x-show="sidebarOpen" class="px-3 pt-4 pb-1.5">
        <p class="text-[11px] font-bold text-emerald-400 uppercase tracking-widest">Monitoring</p>
    </div>
    <a href="{{ route('kaprodi.monitoring.index') }}" class="sidebar-link {{ request()->routeIs('kaprodi.monitoring.index') ? 'active' : '' }} flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-300 hover:text-white text-sm font-semibold transition-all">
        {!! $iconMonitor !!}<span x-show="sidebarOpen" x-transition class="truncate">Monitoring Skripsi</span>
    </a>
    <a href="{{ route('kaprodi.yudisium.index') }}" class="sidebar-link {{ request()->routeIs('kaprodi.yudisium*') ? 'active' : '' }} flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-300 hover:text-white text-sm font-semibold transition-all">
        {!! $iconAward !!}<span x-show="sidebarOpen" x-transition class="truncate">Monitoring Yudisium</span>
    </a>

@elseif($isDekan)
    <a href="{{ route('dekan.dashboard') }}" class="sidebar-link {{ request()->routeIs('dekan.dashboard') ? 'active' : '' }} flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-300 hover:text-white text-sm font-semibold transition-all">
        {!! $iconDashboard !!}<span x-show="sidebarOpen" x-transition class="truncate">Dashboard</span>
    </a>
    <div x-show="sidebarOpen" class="px-3 pt-4 pb-1.5">
        <p class="text-[11px] font-bold text-emerald-400 uppercase tracking-widest">Persetujuan</p>
    </div>
    <a href="{{ route('dekan.approvals.index') }}" class="sidebar-link {{ request()->routeIs('dekan.approvals*') ? 'active' : '' }} flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-300 hover:text-white text-sm font-semibold transition-all">
        {!! $iconCheck !!}<span x-show="sidebarOpen" x-transition class="truncate">Approval SK &amp; Dokumen</span>
    </a>

@elseif($isDosen)
    <a href="{{ route('dosen.dashboard') }}" class="sidebar-link {{ request()->routeIs('dosen.dashboard') ? 'active' : '' }} flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-300 hover:text-white text-sm font-semibold transition-all">
        {!! $iconDashboard !!}<span x-show="sidebarOpen" x-transition class="truncate">Dashboard Dosen</span>
    </a>
    <a href="{{ route('dosen.bimbingan.index') }}" class="sidebar-link {{ request()->routeIs('dosen.bimbingan*') ? 'active' : '' }} flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-300 hover:text-white text-sm font-semibold transition-all">
        {!! $iconDoc !!}<span x-show="sidebarOpen" x-transition class="truncate">Mahasiswa Bimbingan</span>
    </a>
    <a href="{{ route('dosen.nilai.index') }}" class="sidebar-link {{ request()->routeIs('dosen.nilai*') ? 'active' : '' }} flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-300 hover:text-white text-sm font-semibold transition-all">
        {!! $iconCheck !!}<span x-show="sidebarOpen" x-transition class="truncate">Input Nilai Sidang</span>
    </a>
    <a href="{{ route('dosen.evidence.index') }}" class="sidebar-link {{ request()->routeIs('dosen.evidence*') ? 'active' : '' }} flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-300 hover:text-white text-sm font-semibold transition-all">
        {!! $iconFolder !!}<span x-show="sidebarOpen" x-transition class="truncate">Evidence BKD</span>
    </a>

@elseif($isMahasiswa)
    <div x-show="sidebarOpen" class="px-3 pt-2 pb-1.5">
        <p class="text-[11px] font-bold text-emerald-400 uppercase tracking-widest">Portal Mahasiswa</p>
    </div>
    <a href="{{ route('mahasiswa.dashboard') }}" class="sidebar-link {{ request()->routeIs('mahasiswa.dashboard') ? 'active' : '' }} flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-300 hover:text-white text-sm font-semibold transition-all">
        {!! $iconDashboard !!}<span x-show="sidebarOpen" x-transition class="truncate">Dashboard</span>
    </a>
    <a href="{{ route('mahasiswa.pengajuan.index') }}" class="sidebar-link {{ request()->routeIs('mahasiswa.pengajuan*') ? 'active' : '' }} flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-300 hover:text-white text-sm font-semibold transition-all">
        {!! $iconDoc !!}<span x-show="sidebarOpen" x-transition class="truncate">Pengajuan Judul</span>
    </a>
    <a href="{{ route('mahasiswa.bimbingan.index') }}" class="sidebar-link {{ request()->routeIs('mahasiswa.bimbingan*') ? 'active' : '' }} flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-300 hover:text-white text-sm font-semibold transition-all">
        {!! $iconFolder !!}<span x-show="sidebarOpen" x-transition class="truncate">Bimbingan &amp; Revisi</span>
    </a>
    <a href="{{ route('mahasiswa.dokumen.index') }}" class="sidebar-link {{ request()->routeIs('mahasiswa.dokumen*') ? 'active' : '' }} flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-300 hover:text-white text-sm font-semibold transition-all">
        {!! $iconDoc !!}<span x-show="sidebarOpen" x-transition class="truncate">Upload Dokumen</span>
    </a>
    <a href="{{ route('mahasiswa.pengesahan.index') }}" class="sidebar-link {{ request()->routeIs('mahasiswa.pengesahan*') ? 'active' : '' }} flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-300 hover:text-white text-sm font-semibold transition-all">
        {!! $iconCheck !!}<span x-show="sidebarOpen" x-transition class="truncate">Upload Pengesahan</span>
    </a>
    <a href="{{ route('mahasiswa.yudisium.index') }}" class="sidebar-link {{ request()->routeIs('mahasiswa.yudisium*') ? 'active' : '' }} flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-300 hover:text-white text-sm font-semibold transition-all">
        {!! $iconAward !!}<span x-show="sidebarOpen" x-transition class="truncate">Pendaftaran Yudisium</span>
    </a>
    <a href="{{ route('mahasiswa.riwayat.index') }}" class="sidebar-link {{ request()->routeIs('mahasiswa.riwayat*') ? 'active' : '' }} flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-300 hover:text-white text-sm font-semibold transition-all">
        {!! $iconCalendar !!}<span x-show="sidebarOpen" x-transition class="truncate">Riwayat Pengajuan</span>
    </a>
    <a href="{{ route('mahasiswa.notifikasi.index') }}" class="sidebar-link {{ request()->routeIs('mahasiswa.notifikasi*') ? 'active' : '' }} flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-300 hover:text-white text-sm font-semibold transition-all">
        {!! $iconBell !!}<span x-show="sidebarOpen" x-transition class="truncate">Notifikasi</span>
    </a>
@endif
