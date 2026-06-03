<!DOCTYPE html>
<html>
<head>
    <title>Laporan Absensi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        h2 {
            text-align: center;
        }
    </style>
</head>
<body>

    <h2>Laporan Data Absensi Karyawan</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIP</th>
                <th>Nama</th>
                <th>Divisi</th>
                <th>Jabatan</th>
                <th>Jam Masuk</th>
                <th>Jam Keluar</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ optional($item->karyawan)->nip ?? '-' }}</td>
                <td>{{ optional($item->karyawan)->nama ?? '-' }}</td>
                <td>{{ optional($item->karyawan)->divisi ?? '-' }}</td>
                <td>{{ optional($item->karyawan)->jabatan ?? '-' }}</td>
                <td>{{ $item->jam_masuk ?? '-' }}</td>
                <td>{{ $item->jam_keluar ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
