@extends("layouts.app")
@section("title","Verifikasi Berkas Yudisium")
@section("content")
<div class="space-y-6">
    <a href="{{route("admin.yudisium.index")}}" class="text-xs text-blue-600 hover:underline">← Kembali ke Pendaftaran Yudisium</a>
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
        <h1 class="text-xl font-bold text-slate-900">{{$yudisium->mahasiswa?->nama}}</h1>
        <p class="text-xs text-slate-500 mb-6">NIM: {{$yudisium->mahasiswa?->nim}} · IPK: {{$yudisium->ipk}}</p>
        @if($yudisium->status !== "disetujui")
        <form method="POST" action="{{route("admin.yudisium.verifikasi",$yudisium)}}">@csrf @method("PATCH")<button class="px-6 py-2 bg-green-600 text-white font-semibold text-sm rounded-xl hover:bg-green-700">Setujui Pendaftaran Yudisium</button></form>
        @endif
    </div>
</div>
@endsection