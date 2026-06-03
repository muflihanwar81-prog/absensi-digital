<link rel="stylesheet" href="{{ asset('style/aan_style.css') }}">
<h1>Ini Judul Merah</h1>
<img src="{{ asset('image/download.jpg') }}" alt="">
<img src="{{ asset('image/nissan-skyline-gtr-r34.jpeg') }}" alt="">
<table border="1">
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
            <td>{{ $dataku['harga'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
</html>