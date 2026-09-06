<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><title>Rekap Skripsi</title>
    <style>
        body { font-family: 'Times New Roman', serif; font-size: 10pt; padding: 15mm 20mm; }
        h1 { text-align: center; font-size: 13pt; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 5px 8px; vertical-align: top; }
        th { background: #e8e8e8; font-weight: 700; text-align: center; }
        td { font-size: 9.5pt; }
    </style>
</head>
<body>
    <h1>Rekap Data Skripsi<br>{{ now()->translatedFormat('d F Y') }}</h1>
    <table>
        <thead>
            <tr>
                <th>No</th><th>NIM</th><th>Nama</th><th>Prodi</th><th>Judul</th><th>Tahun Akademik</th><th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($skripsiList as $i => $s)
            <tr>
                <td style="text-align:center">{{ $i+1 }}</td>
                <td>{{ $s->mahasiswa?->nim }}</td>
                <td>{{ $s->mahasiswa?->nama }}</td>
                <td>{{ $s->mahasiswa?->prodi?->kode }}</td>
                <td>{{ $s->judul }}</td>
                <td style="text-align:center">{{ $s->tahunAkademik?->label }}</td>
                <td style="text-align:center">{{ ucfirst($s->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
