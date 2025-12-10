
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Pemasukan</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        h2 { text-align:center; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #444; padding: 6px; }
        th { background: #f0f0f0; }
        .summary { margin-top: 20px; font-size: 16px; }
    </style>
</head>
<body>

<h2>Laporan Pemasukan</h2>

<p><strong>Bulan:</strong> {{ $bulan }} {{ $tahun }}</p>
<p><strong>Tanggal Dicetak:</strong> {{ $tanggalCetak }}</p>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Keterangan</th>
            <th>Nominal</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                <td>{{ $item->keterangan ?? '-' }}</td>
                <td>Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="summary">
    <strong>Total Pemasukan:</strong>  
    Rp {{ number_format($total, 0, ',', '.') }}
</div>

</body>
</html>
