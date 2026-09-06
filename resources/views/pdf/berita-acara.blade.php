<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Berita Acara Ujian Skripsi</title>
    <style>
        body { font-family: 'Times New Roman', serif; font-size: 12pt; margin: 0; padding: 20mm 25mm; }
        .header { text-align: center; border-bottom: 3px solid #000; padding-bottom: 8px; margin-bottom: 20px; }
        .header h1 { font-size: 14pt; font-weight: 900; text-transform: uppercase; }
        .header h2 { font-size: 11pt; font-weight: 700; text-transform: uppercase; }
        .header p { font-size: 9pt; }
        .title { text-align: center; font-size: 13pt; font-weight: 700; text-decoration: underline; text-transform: uppercase; margin: 20px 0 6px; }
        .nomor { text-align: center; margin-bottom: 20px; }
        table.info td { padding: 3px 6px; vertical-align: top; }
        table.info td:first-child { width: 40%; }
        table.nilai { width: 100%; border-collapse: collapse; margin: 10px 0; font-size: 11pt; }
        table.nilai th, table.nilai td { border: 1px solid #000; padding: 6px; text-align: center; }
        table.nilai th { background: #f0f0f0; font-weight: 700; }
        .result-box { border: 2px solid #000; padding: 12px; margin: 16px 0; text-align: center; }
        .result-box p { font-size: 13pt; font-weight: 700; }
        .sign-row { display: flex; justify-content: space-around; margin-top: 40px; }
        .sign-box { text-align: center; width: 180px; }
        .sign-space { height: 60px; }
        .sign-name { font-weight: 700; }
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

    <div class="title">Berita Acara Ujian Skripsi</div>
    <div class="nomor">Nomor: {{ $beritaAcara->nomor_ba ?? '____/____/____' }}</div>

    <table class="info" style="width:100%; margin-bottom:16px;">
        <tr><td>Nama</td><td>:</td><td><strong>{{ $beritaAcara->ujian->skripsi->mahasiswa->nama }}</strong></td></tr>
        <tr><td>NIM</td><td>:</td><td>{{ $beritaAcara->ujian->skripsi->mahasiswa->nim }}</td></tr>
        <tr><td>Program Studi</td><td>:</td><td>{{ $beritaAcara->ujian->skripsi->mahasiswa->prodi?->nama }}</td></tr>
        <tr><td>Judul</td><td>:</td><td><em>{{ $beritaAcara->ujian->skripsi->judul }}</em></td></tr>
        <tr><td>Tanggal Ujian</td><td>:</td><td>{{ $beritaAcara->ujian->jadwal?->translatedFormat('d F Y, H:i') }} WITA</td></tr>
        <tr><td>Tempat</td><td>:</td><td>{{ $beritaAcara->ujian->tempat }}</td></tr>
    </table>

    <p style="font-weight:700; margin-bottom:6px;">Daftar Nilai Ujian:</p>
    <table class="nilai">
        <thead>
            <tr>
                <th>No</th><th>Nama Penguji</th><th>Peran</th>
                <th>Penguasaan Materi</th><th>Kemampuan Presentasi</th><th>Penulisan</th><th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($beritaAcara->ujian->penguji as $i => $p)
            <tr>
                <td>{{ $i+1 }}</td>
                <td style="text-align:left">{{ $p->dosen?->nama_lengkap }}</td>
                <td>{{ $p->peran_label }}</td>
                <td>{{ $p->nilai?->nilai_penguasaan_materi ?? '-' }}</td>
                <td>{{ $p->nilai?->nilai_kemampuan_presentasi ?? '-' }}</td>
                <td>{{ $p->nilai?->nilai_penulisan ?? '-' }}</td>
                <td><strong>{{ $p->nilai?->nilai_total ?? '-' }}</strong></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="result-box">
        <p>NILAI AKHIR: {{ number_format($beritaAcara->nilai_akhir ?? 0, 2) }} ({{ $beritaAcara->predikat }})</p>
        <p>KEPUTUSAN: {{ strtoupper(str_replace('_', ' ', $beritaAcara->keputusan)) }}</p>
    </div>

    @if($beritaAcara->rekomendasi)
    <p><strong>Rekomendasi:</strong> {{ $beritaAcara->rekomendasi }}</p>
    @endif

    <div class="sign-row">
        @foreach($beritaAcara->ujian->penguji as $p)
        <div class="sign-box">
            <p>{{ $p->peran_label }}</p>
            <div class="sign-space"></div>
            <p class="sign-name">{{ $p->dosen?->nama_lengkap }}</p>
        </div>
        @endforeach
    </div>
</body>
</html>
