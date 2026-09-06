<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lembar Pengesahan Skripsi</title>
    <style>
        body { font-family: 'Times New Roman', serif; font-size: 12pt; margin: 0; padding: 25mm 30mm; }
        .title { text-align: center; font-size: 13pt; font-weight: 700; text-transform: uppercase; margin-bottom: 6px; }
        .judul { text-align: center; font-size: 14pt; font-weight: 900; text-transform: uppercase; line-height: 1.5; margin: 16px 0; }
        .sub { text-align: center; font-size: 11pt; margin-bottom: 20px; }
        table.info { margin: 16px auto; }
        table.info td { padding: 4px 8px; font-size: 11pt; }
        table.info td:first-child { font-weight: 600; }
        .divider { border: 0; border-top: 2px solid #000; margin: 20px 0; }
        .sign-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-top: 30px; }
        .sign-box { text-align: center; }
        .sign-space { height: 70px; }
        .sign-name { font-weight: 700; text-decoration: underline; }
        .sign-info { font-size: 10pt; }
        .approved-stamp { color: #1a56db; font-style: italic; font-size: 10pt; }
    </style>
</head>
<body>
    <div style="text-align:center; margin-bottom:12px;">
        @if(file_exists(public_path('asset/logo.png')))
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('asset/logo.png'))) }}" style="height: 60px;">
        @endif
    </div>
    <div class="title">Lembar Pengesahan Skripsi</div>

    <div class="judul">{{ $pengesahan->skripsi->judul }}</div>

    <div class="sub">
        Diajukan sebagai salah satu syarat untuk memperoleh gelar Sarjana Teknik (S.T.)<br>
        pada Program Studi {{ $pengesahan->skripsi->mahasiswa->prodi?->nama }}
    </div>

    <table class="info">
        <tr><td>Disusun oleh</td><td>:</td><td>{{ $pengesahan->skripsi->mahasiswa->nama }}</td></tr>
        <tr><td>NIM</td><td>:</td><td>{{ $pengesahan->skripsi->mahasiswa->nim }}</td></tr>
        <tr><td>Program Studi</td><td>:</td><td>{{ $pengesahan->skripsi->mahasiswa->prodi?->nama }}</td></tr>
        <tr><td>Fakultas</td><td>:</td><td>{{ $settings['nama_fakultas'] ?? 'Fakultas Teknik' }}</td></tr>
    </table>

    <hr class="divider">
    <p style="text-align:center; margin-bottom:16px;">Telah disetujui dan disahkan oleh Tim Pembimbing:</p>

    <div class="sign-grid">
        @foreach($pengesahan->skripsi->pembimbing as $p)
        <div class="sign-box">
            <p>{{ $p->peran }},</p>
            <div class="sign-space">
                @if($pengesahan->status === 'terverifikasi')
                <p class="approved-stamp">[TTD]</p>
                @endif
            </div>
            <p class="sign-name">{{ $p->dosen?->nama_lengkap }}</p>
            <p class="sign-info">NIDN. {{ $p->dosen?->nidn }}</p>
        </div>
        @endforeach
    </div>

    <div style="margin-top:40px; text-align:right;">
        <p>Mengetahui,<br>Dekan {{ $settings['nama_fakultas'] ?? 'Fakultas Teknik' }}</p>
        <div class="sign-space">
            @if($pengesahan->status === 'terverifikasi')
            <p class="approved-stamp" style="text-align:right">[TTD]</p>
            @endif
        </div>
        <p class="sign-name" style="text-align:right">{{ $settings['nama_dekan'] ?? '' }}</p>
        <p class="sign-info" style="text-align:right">NIP. {{ $settings['nip_dekan'] ?? '' }}</p>
    </div>

    <div style="text-align:center; margin-top:30px; font-size:10pt; color:#555;">
        Disahkan di: {{ $pengesahan->verified_at ? $pengesahan->verified_at->translatedFormat('d F Y') : now()->translatedFormat('d F Y') }}
    </div>
</body>
</html>
