<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
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
    @production
        <script defer src="https://analytics.gistreader.com/script.js" data-website-id="7e435c54-925c-49d5-a922-5e10df3fb149"></script>
    @endproduction
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body>
<main>
    @yield('content')
</main>
</body>
</html>
