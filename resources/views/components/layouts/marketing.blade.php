<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="text-zinc-950 antialiased">
        {{ $slot }}
    </body>
</html>
