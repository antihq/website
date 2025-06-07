<!DOCTYPE html>
<html lang="{{ $page->language ?? 'en' }}">
    <head>
        @include('_partials.head')
    </head>
    <body class="text-zinc-950 antialiased">
        {{ $slot }}
    </body>
</html>
