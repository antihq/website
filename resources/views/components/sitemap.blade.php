@props(['heading', 'links'])

<div>
    <h3 class="text-sm/6 font-medium text-zinc-950/50">{{ $heading }}</h3>
    <ul class="mt-6 space-y-4 text-sm/6">
        @foreach($links as $link)
            <li>
                <a href="{{ $link['href'] }}" class="font-medium text-zinc-950 hover:text-zinc-950/75">
                    {{ $link['text'] }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
