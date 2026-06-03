<!DOCTYPE html>
<html>
<head>
    <title>Daftar Barang</title>
</head>
<body>
<h1>Daftar Barang</h1>
<table border="1" cellpadding="10" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Harga</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $dataku)
        <tr>
            <td>{{ $dataku['id'] }}</td>
            <td>{{ $dataku['nama'] }}</td>
            <td>Rp{{ number_format($dataku['harga']) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>