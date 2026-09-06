<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><title>SK Penguji</title>
    <style>
        body { font-family: 'Times New Roman',serif; font-size:12pt; padding:20mm 25mm; }
        .header { text-align:center; border-bottom:3px solid #000; padding-bottom:8px; margin-bottom:20px; }
        .header h1 { font-size:14pt; font-weight:900; text-transform:uppercase; }
        .header h2 { font-size:11pt; font-weight:700; text-transform:uppercase; }
        .title { text-align:center; font-size:13pt; font-weight:700; text-decoration:underline; text-transform:uppercase; margin:20px 0 6px; }
        .nomor { text-align:center; margin-bottom:20px; }
        table.info td { padding:3px 6px; vertical-align:top; }
        table.info td:first-child { width:40%; }
        .sign-area { margin-top:40px; text-align:right; }
        .sign-space { height:70px; }
        .sign-name { font-weight:700; text-decoration:underline; }
    </style>
</head>
<body>
    <div class="header">
        @if(file_exists(public_path('asset/logo.png')))
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('asset/logo.png'))) }}" style="height: 55px; margin-bottom: 6px;">
        @endif
        <h1>{{ $settings['nama_institusi'] ?? 'Universitas Muhammadiyah Maluku Utara' }}</h1>
        <h2>{{ $settings['nama_fakultas'] ?? 'Fakultas Teknik' }}</h2>
        <p>{{ $settings['alamat'] ?? '' }}</p>
    </div>

    <div class="title">Surat Keputusan Tim Penguji Skripsi</div>
    <div class="nomor">Nomor: {{ $skPenguji->nomor_sk ?? '____/____/____' }}</div>

    <p style="line-height:1.8; margin-bottom:10px;">Dekan Fakultas Teknik menetapkan Tim Penguji Ujian Skripsi untuk mahasiswa berikut:</p>

    <table class="info" style="width:100%; margin-bottom:12px;">
        <tr><td>Nama</td><td>:</td><td><strong>{{ $skPenguji->ujian->skripsi->mahasiswa->nama }}</strong></td></tr>
        <tr><td>NIM</td><td>:</td><td>{{ $skPenguji->ujian->skripsi->mahasiswa->nim }}</td></tr>
        <tr><td>Program Studi</td><td>:</td><td>{{ $skPenguji->ujian->skripsi->mahasiswa->prodi?->nama }}</td></tr>
        <tr><td>Judul Skripsi</td><td>:</td><td><em>{{ $skPenguji->ujian->skripsi->judul }}</em></td></tr>
        <tr><td>Waktu Ujian</td><td>:</td><td>{{ $skPenguji->ujian->jadwal?->translatedFormat('d F Y, H:i') }} WITA</td></tr>
        <tr><td>Tempat</td><td>:</td><td>{{ $skPenguji->ujian->tempat }}</td></tr>
    </table>

    <p style="font-weight:700; margin-bottom:6px;">Tim Penguji:</p>
    <table class="info" style="width:100%;">
        @foreach($skPenguji->ujian->penguji as $p)
        <tr>
            <td>{{ $p->peran_label }}</td><td>:</td>
            <td>{{ $p->dosen?->nama_lengkap }} (NIDN. {{ $p->dosen?->nidn }})</td>
        </tr>
        @endforeach
    </table>

    <div class="sign-area">
        <p>Ternate, {{ $skPenguji->tanggal_sk ? \Carbon\Carbon::parse($skPenguji->tanggal_sk)->translatedFormat('d F Y') : now()->translatedFormat('d F Y') }}</p>
        <p>Dekan Fakultas Teknik</p>
        <div class="sign-space"></div>
        <p class="sign-name">{{ $settings['nama_dekan'] ?? '' }}</p>
        <p>NIP. {{ $settings['nip_dekan'] ?? '' }}</p>
    </div>
</body>
</html>
