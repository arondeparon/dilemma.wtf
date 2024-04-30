<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>😱</text></svg>">
    <script src="//unpkg.com/alpinejs" defer></script>
    {{--    og image--}}
    @if (isset($hash))
        <meta property="og:image" content="/opengraph/{{ md5(url()->current()) }}.png">
    @endif
    <title>@yield('title', 'Dilemma.wtf')</title>
    @vite('resources/css/app.css')
</head>
<body>
<main>
    @yield('content')
</main>
</body>
</html>
