<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>😱</text></svg>">
    <script src="//unpkg.com/alpinejs" defer></script>
    @if (isset($hash))
        <meta property="og:image" content="{{ url('/storage/opengraph/' . $hash) }}.png">
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:site" content="@arondeparon" />
        <meta name="twitter:title" content="Dilemma.wtf" />
        <meta name="twitter:description" content="@yield('title')" />
        <meta name="twitter:image" content="{{ url('/storage/opengraph/' . $hash) }}.png" />
    @endif
    <title>@yield('title', 'Dilemma.wtf')</title>
    <script defer src="https://analytics.gistreader.com/script.js" data-website-id="7e435c54-925c-49d5-a922-5e10df3fb149"></script>
    @vite('resources/css/app.css')
</head>
<body>
<main>
    @yield('content')
</main>
</body>
</html>
