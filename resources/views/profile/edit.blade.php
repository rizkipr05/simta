@extends('layouts.app')
@section('title', 'Profil Saya')
@section('breadcrumb')
    <span class="text-slate-800 font-bold">Profil Saya</span>
@endsection

@section('content')
<div class="max-w-4xl space-y-6">
    <div>
        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Pengaturan Profil</h1>
        <p class="text-slate-500 text-xs mt-1">Kelola informasi akun dan kata sandi Anda</p>
    </div>

    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
        <h2 class="text-base font-extrabold text-slate-900 mb-1">Informasi Profil</h2>
        <p class="text-xs text-slate-500 mb-6">Perbarui nama pengguna dan alamat email Anda.</p>
        @include('profile.partials.update-profile-information-form')
    </div>

    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
        <h2 class="text-base font-extrabold text-slate-900 mb-1">Ubah Password</h2>
        <p class="text-xs text-slate-500 mb-6">Pastikan akun Anda menggunakan kata sandi yang kuat dan aman.</p>
        @include('profile.partials.update-password-form')
    </div>

    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
        <h2 class="text-base font-extrabold text-rose-600 mb-1">Hapus Akun</h2>
        <p class="text-xs text-slate-500 mb-6">Tindakan ini permanen. Semua data akun Anda akan dihapus.</p>
        @include('profile.partials.delete-user-form')
    </div>
</div>
@endsection
