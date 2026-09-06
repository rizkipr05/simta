<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SK Pembimbing - {{ $skPembimbing->nomor_sk }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Times New Roman', serif; font-size: 12pt; color: #000; background: #fff; }
        .page { width: 210mm; min-height: 297mm; padding: 20mm 25mm; margin: 0 auto; }
        .header { text-align: center; border-bottom: 3px solid #000; padding-bottom: 8px; margin-bottom: 16px; }
        .header-logo-row { display: flex; align-items: center; justify-content: center; gap: 20px; margin-bottom: 6px; }
        .header h1 { font-size: 14pt; font-weight: 900; text-transform: uppercase; line-height: 1.3; }
        .header h2 { font-size: 11pt; font-weight: 700; text-transform: uppercase; }
        .header p { font-size: 9pt; }
        .content { margin-top: 20px; }
        .title { text-align: center; font-size: 13pt; font-weight: 700; text-transform: uppercase; text-decoration: underline; margin-bottom: 6px; }
        .nomor { text-align: center; font-size: 11pt; margin-bottom: 20px; }
        .body-text { text-align: justify; line-height: 1.8; margin-bottom: 10px; }
        table.info { width: 100%; border-collapse: collapse; margin: 8px 0 12px 0; }
        table.info td { padding: 3px 6px; vertical-align: top; font-size: 11pt; }
        table.info td:first-child { width: 35%; font-weight: 600; }
        table.info td:nth-child(2) { width: 5%; }
        .article { margin: 12px 0; }
        .article h3 { font-weight: 700; margin-bottom: 4px; }
        .sign-area { margin-top: 40px; display: flex; justify-content: flex-end; }
        .sign-box { text-align: center; width: 250px; }
        .sign-box p { font-size: 11pt; }
        .sign-space { height: 70px; }
        .sign-name { font-weight: 700; text-decoration: underline; font-size: 12pt; }
        .sign-nip { font-size: 10pt; }
        .footer { position: fixed; bottom: 10mm; left: 0; right: 0; text-align: center; font-size: 8pt; color: #666; border-top: 1px solid #ccc; padding-top: 4px; }
    </style>
</head>
<body>
<div class="page">
    <div class="header">
        @if(file_exists(public_path('asset/logo.png')))
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('asset/logo.png'))) }}" style="height: 55px; margin-bottom: 6px;">
        @endif
        <h1>{{ $settings['nama_institusi'] ?? 'Universitas Muhammadiyah Maluku Utara' }}</h1>
        <h2>{{ $settings['nama_fakultas'] ?? 'Fakultas Teknik' }}</h2>
        <p>{{ $settings['alamat'] ?? 'Jl. Bumi Bahari, Ternate, Maluku Utara' }} | Telp. {{ $settings['telepon'] ?? '' }} | {{ $settings['email_institusi'] ?? '' }}</p>
    </div>

    <div class="content">
        <div class="title">Surat Keputusan Pembimbing Skripsi</div>
        <div class="nomor">Nomor: {{ $skPembimbing->nomor_sk ?? '____/____/____' }}</div>

        <p class="body-text">
            Dekan Fakultas Teknik Universitas Muhammadiyah Maluku Utara, berdasarkan pertimbangan akademik dan kelayakan penelitian, dengan ini menetapkan dosen pembimbing skripsi untuk mahasiswa berikut:
        </p>

        <div class="article">
            <h3>Mahasiswa yang Dibimbing:</h3>
            <table class="info">
                <tr><td>Nama Mahasiswa</td><td>:</td><td>{{ $skPembimbing->skripsi->mahasiswa->nama }}</td></tr>
                <tr><td>NIM</td><td>:</td><td>{{ $skPembimbing->skripsi->mahasiswa->nim }}</td></tr>
                <tr><td>Program Studi</td><td>:</td><td>{{ $skPembimbing->skripsi->mahasiswa->prodi?->nama }}</td></tr>
                <tr><td>Judul Skripsi</td><td>:</td><td>{{ $skPembimbing->skripsi->judul }}</td></tr>
            </table>
        </div>

        <div class="article">
            <h3>Dosen Pembimbing:</h3>
            @foreach($skPembimbing->skripsi->pembimbing as $p)
            <table class="info" style="margin-bottom:6px">
                <tr><td>{{ $p->peran }}</td><td>:</td><td></td></tr>
                <tr><td>Nama</td><td>:</td><td>{{ $p->dosen?->nama_lengkap }}</td></tr>
                <tr><td>NIDN</td><td>:</td><td>{{ $p->dosen?->nidn }}</td></tr>
                <tr><td>Jabatan</td><td>:</td><td>{{ $p->dosen?->jabatan }}</td></tr>
            </table>
            @endforeach
        </div>

        <div class="article">
            <h3>Ketentuan:</h3>
            <ol style="margin-left:20px; line-height:1.8">
                <li>Pembimbing I bertanggung jawab terhadap metodologi dan substansi penelitian.</li>
                <li>Pembimbing II bertanggung jawab terhadap teknis penulisan karya ilmiah.</li>
                <li>Proses bimbingan dilaksanakan sesuai dengan ketentuan akademik yang berlaku.</li>
                <li>SK ini berlaku sejak tanggal ditetapkan sampai dengan selesainya ujian skripsi mahasiswa bersangkutan.</li>
            </ol>
        </div>

        <p class="body-text">
            Ditetapkan di : {{ $settings['tempat'] ?? 'Ternate' }}<br>
            Pada tanggal  : {{ $skPembimbing->tanggal_sk ? \Carbon\Carbon::parse($skPembimbing->tanggal_sk)->translatedFormat('d F Y') : now()->translatedFormat('d F Y') }}
        </p>

        <div class="sign-area">
            <div class="sign-box">
                <p>Dekan Fakultas Teknik,</p>
                <br>
                @if($skPembimbing->status === 'disetujui')
                <p style="font-style:italic;color:#1a56db;">[Telah Ditandatangani Secara Digital]</p>
                @endif
                <div class="sign-space"></div>
                <p class="sign-name">{{ $settings['nama_dekan'] ?? 'Dr. Ir. H. Syahrul Ramadhan, M.T.' }}</p>
                <p class="sign-nip">NIP. {{ $settings['nip_dekan'] ?? '-' }}</p>
            </div>
        </div>
    </div>
</div>
</body>
</html>
