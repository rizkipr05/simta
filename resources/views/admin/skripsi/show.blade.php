@extends("layouts.app")
@section("title","Detail Skripsi")
@section("content")
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <a href="{{route("admin.skripsi.index")}}" class="text-xs text-blue-600 hover:underline">← Kembali ke Manajemen Skripsi</a>
            <h1 class="text-2xl font-bold text-slate-900 mt-1">Detail Skripsi Mahasiswa</h1>
        </div>
        <span class="status-badge bg-blue-100 text-blue-700">{{ucfirst($skripsi->status)}}</span>
    </div>

    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
        <div class="flex items-center gap-4 mb-6 pb-6 border-b">
            <img src="{{$skripsi->mahasiswa?->foto_url}}" class="w-14 h-14 rounded-2xl object-cover">
            <div>
                <h2 class="text-lg font-bold text-slate-900">{{$skripsi->mahasiswa?->nama}}</h2>
                <p class="text-xs text-slate-500">{{$skripsi->mahasiswa?->nim}} · {{$skripsi->mahasiswa?->prodi?->nama}}</p>
            </div>
        </div>

        <div class="space-y-4 text-sm">
            <div><p class="text-xs font-semibold text-slate-400 uppercase">Judul Skripsi</p><p class="font-semibold text-slate-900 text-base mt-1">{{$skripsi->judul}}</p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase">Bidang Kajian</p><p class="text-slate-700">{{$skripsi->bidang_kajian ?? "-"}}</p></div>
            <div><p class="text-xs font-semibold text-slate-400 uppercase">Deskripsi</p><p class="text-slate-700 leading-relaxed">{{$skripsi->deskripsi ?? "-"}}</p></div>
        </div>

        @if($skripsi->status === "pengajuan")
        <div class="mt-8 pt-6 border-t flex gap-3">
            <form method="POST" action="{{route("admin.skripsi.terima",$skripsi)}}">@csrf @method("PATCH")<button class="px-5 py-2 bg-green-600 text-white text-sm font-semibold rounded-xl hover:bg-green-700">Terima Pengajuan</button></form>
            <form method="POST" action="{{route("admin.skripsi.tolak",$skripsi)}}" class="flex gap-2">@csrf @method("PATCH")<input name="catatan_penolakan" placeholder="Alasan penolakan..." class="px-3 py-2 text-xs border rounded-xl"><button class="px-4 py-2 bg-red-600 text-white text-xs font-semibold rounded-xl hover:bg-red-700">Tolak</button></form>
        </div>
        @endif
    </div>

    {{-- Penetapan Pembimbing --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
        <h2 class="font-bold text-slate-900 mb-4">Dosen Pembimbing</h2>
        <div class="space-y-3 mb-6">
            @forelse($skripsi->pembimbing as $p)
            <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                <div><p class="font-semibold text-slate-900 text-sm">{{$p->dosen?->nama_lengkap}}</p><p class="text-xs text-slate-500">{{$p->peran_label ?? "Pembimbing"}}</p></div>
                <form method="POST" action="{{route("admin.pembimbing.destroy",$p)}}">@csrf @method("DELETE")<button class="text-xs text-red-600 hover:underline">Hapus</button></form>
            </div>
            @empty
            <p class="text-slate-400 text-xs italic">Belum ada dosen pembimbing ditetapkan</p>
            @endforelse
        </div>

        <form method="POST" action="{{route("admin.pembimbing.store",$skripsi)}}" class="flex gap-3">
            @csrf
            <select name="dosen_id" class="flex-1 px-4 py-2 border text-sm rounded-xl" required>
                <option value="">Pilih Dosen...</option>
                @foreach($dosenList as $d)<option value="{{$d->id}}">{{$d->nama_lengkap}}</option>@endforeach
            </select>
            <select name="urutan" class="px-4 py-2 border text-sm rounded-xl" required><option value="1">Pembimbing 1</option><option value="2">Pembimbing 2</option></select>
            <button type="submit" class="px-5 py-2 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700">Tetapkan</button>
        </form>
    </div>
</div>
@endsection