<!DOCTYPE html>
<html>
<head>
    <title>My App</title>
</head>
<body>

    <header>
        @include('components.header')
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        @include('components.footer')
    </footer>

</body>
</html>
