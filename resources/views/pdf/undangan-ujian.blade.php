<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Undangan Ujian Skripsi</title>
    <style>
        body { font-family: 'Times New Roman', serif; font-size: 12pt; margin: 0; padding: 20mm 25mm; }
        .header { text-align: center; border-bottom: 3px solid #000; padding-bottom: 8px; margin-bottom: 20px; }
        .header h1 { font-size: 14pt; font-weight: 900; text-transform: uppercase; }
        .header h2 { font-size: 11pt; font-weight: 700; text-transform: uppercase; }
        .header p { font-size: 9pt; }
        .title { text-align: center; font-size: 13pt; font-weight: 700; text-decoration: underline; text-transform: uppercase; margin: 20px 0 6px; }
        .nomor { text-align: center; font-size: 11pt; margin-bottom: 20px; }
        .body-text { line-height: 1.8; margin-bottom: 10px; text-align: justify; }
        table.info { width: 100%; margin: 10px 0; }
        table.info td { padding: 3px 6px; vertical-align: top; }
        table.info td:first-child { width: 40%; }
        .sign-row { display: flex; justify-content: space-between; margin-top: 40px; }
        .sign-box { text-align: center; width: 200px; }
        .sign-space { height: 70px; }
        .sign-name { font-weight: 700; text-decoration: underline; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $settings['nama_institusi'] ?? 'Universitas Muhammadiyah Maluku Utara' }}</h1>
        <h2>{{ $settings['nama_fakultas'] ?? 'Fakultas Teknik' }}</h2>
        <p>{{ $settings['alamat'] ?? '' }} | {{ $settings['telepon'] ?? '' }}</p>
    </div>

    <div class="title">Undangan Ujian Skripsi</div>
    <div class="nomor">Nomor: UND.UJIAN/{{ str_pad($ujian->id, 3, '0', STR_PAD_LEFT) }}/{{ now()->format('m/Y') }}</div>

    <p class="body-text">Dengan hormat, mengundang Bapak/Ibu dosen untuk hadir sebagai tim penguji dalam Ujian Skripsi:</p>

    <table class="info">
        <tr><td>Nama Mahasiswa</td><td>:</td><td><strong>{{ $ujian->skripsi->mahasiswa->nama }}</strong></td></tr>
        <tr><td>NIM</td><td>:</td><td>{{ $ujian->skripsi->mahasiswa->nim }}</td></tr>
        <tr><td>Program Studi</td><td>:</td><td>{{ $ujian->skripsi->mahasiswa->prodi?->nama }}</td></tr>
        <tr><td>Judul Skripsi</td><td>:</td><td><em>{{ $ujian->skripsi->judul }}</em></td></tr>
        <tr><td>Hari/Tanggal</td><td>:</td><td>{{ $ujian->jadwal?->translatedFormat('l, d F Y') }}</td></tr>
        <tr><td>Waktu</td><td>:</td><td>{{ $ujian->jadwal?->format('H:i') }} WITA</td></tr>
        <tr><td>Tempat</td><td>:</td><td>{{ $ujian->tempat }} {{ $ujian->ruangan ? '/ Ruang ' . $ujian->ruangan : '' }}</td></tr>
    </table>

    <p class="body-text"><strong>Tim Penguji:</strong></p>
    <table class="info">
        @foreach($ujian->penguji as $p)
        <tr>
            <td>{{ $p->peran_label }}</td>
            <td>:</td>
            <td>{{ $p->dosen?->nama_lengkap }}</td>
        </tr>
        @endforeach
    </table>

    <p class="body-text"><strong>Tim Pembimbing:</strong></p>
    <table class="info">
        @foreach($ujian->skripsi->pembimbing as $pb)
        <tr>
            <td>{{ $pb->peran }}</td>
            <td>:</td>
            <td>{{ $pb->dosen?->nama_lengkap }}</td>
        </tr>
        @endforeach
    </table>

    <p class="body-text">Demikian undangan ini kami sampaikan. Atas kehadiran dan partisipasi Bapak/Ibu, kami ucapkan terima kasih.</p>

    <div class="sign-row">
        <div class="sign-box">
            <p>Mengetahui,<br>Dekan Fakultas Teknik</p>
            <div class="sign-space"></div>
            <p class="sign-name">{{ $settings['nama_dekan'] ?? 'Dr. Ir. H. Syahrul Ramadhan, M.T.' }}</p>
        </div>
        <div class="sign-box">
            <p>{{ now()->translatedFormat('d F Y') }}<br>Pengelola Skripsi</p>
            <div class="sign-space"></div>
            <p class="sign-name">_______________________</p>
        </div>
    </div>
</body>
</html>
