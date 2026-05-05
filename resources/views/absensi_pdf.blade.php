<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Absensi</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
    </style>
</head>
<body>

<h2>Laporan Absensi</h2>
<a href="{{ route('absensi.pdf', request()->all()) }}"
   class="bg-green-500 text-white px-4 py-2 rounded">
   Export PDF
</a>
<table>
    <thead>
        <tr>
            <th>NIP</th>
            <th>Nama</th>
            <th>Tanggal</th>
            <th>Status</th>
            <th>Divisi</th>
            <th>Jabatan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($absensi as $a)
        <tr>
            <td>{{ optional($a->karyawan)->nip }}</td>
            <td>{{ optional($a->karyawan)->nama }}</td>
            <td>{{ $a->tanggal }}</td>
            <td>{{ $a->status }}</td>
            <td>{{ optional($a->karyawan)->divisi }}</td>
            <td>{{ optional($a->karyawan)->jabatan }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>