@extends("layouts.app")
@section("title","Detail Ujian")
@section("content")
<div class="space-y-6">
    <a href="{{route("admin.ujian.index")}}" class="text-xs text-blue-600 hover:underline">← Kembali ke Jadwal Ujian</a>
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
        <h1 class="text-xl font-bold text-slate-900">Ujian {{$ujian->skripsi?->mahasiswa?->nama}}</h1>
        <p class="text-xs text-slate-500">Jadwal: {{$ujian->jadwal?->format("d M Y H:i")}} · Tempat: {{$ujian->tempat}}</p>
    </div>
</div>
@endsection