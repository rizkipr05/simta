<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><title>Rekap Yudisium</title>
    <style>
        body { font-family: 'Times New Roman', serif; font-size: 10pt; padding: 15mm 20mm; }
        h1 { text-align: center; font-size: 13pt; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 5px 8px; }
        th { background: #e8e8e8; font-weight: 700; text-align: center; }
    </style>
</head>
<body>
    <h1>Rekap Pendaftaran Yudisium<br>{{ now()->translatedFormat('d F Y') }}</h1>
    <table>
        <thead>
            <tr><th>No</th><th>NIM</th><th>Nama</th><th>Prodi</th><th>Periode</th><th>Tgl Daftar</th><th>Status</th></tr>
        </thead>
        <tbody>
            @foreach($pendaftaranList as $i => $p)
            <tr>
                <td style="text-align:center">{{ $i+1 }}</td>
                <td>{{ $p->mahasiswa?->nim }}</td>
                <td>{{ $p->mahasiswa?->nama }}</td>
                <td style="text-align:center">{{ $p->mahasiswa?->prodi?->kode }}</td>
                <td>{{ $p->periode?->nama_periode }}</td>
                <td style="text-align:center">{{ $p->tanggal_daftar?->format('d/m/Y') }}</td>
                <td style="text-align:center">{{ ucfirst($p->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
