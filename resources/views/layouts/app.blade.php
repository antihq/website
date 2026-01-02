<x-layouts::app.header :title="$title ?? null">
    <flux:main class="flex flex-1 flex-col pt-0! pb-2! px-0! lg:px-2">
        <div class="grow p-6 lg:rounded-lg lg:bg-white lg:p-10 lg:shadow-xs lg:ring-1 lg:ring-zinc-950/5 dark:lg:bg-zinc-900 dark:lg:ring-white/10">
            {{ $slot }}
        </div>
    </flux:main>
</x-layouts::app.header>
