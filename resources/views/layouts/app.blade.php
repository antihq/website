<x-layouts::app.header :title="$title ?? null">
    <flux:main class="lg:bg-white dark:lg:bg-zinc-900">
        {{ $slot }}
    </flux:main>
</x-layouts::app.header>
