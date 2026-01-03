<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="dark antialiased lg:bg-zinc-100 dark:bg-zinc-900 dark:lg:bg-zinc-950"
>
    <head>
        @include('partials.head')
    </head>
    <body class="flex min-h-svh w-full flex-col bg-white lg:bg-zinc-100 dark:bg-zinc-900 dark:lg:bg-zinc-950">
        <livewire:layouts.app.header />

        <!-- Mobile Menu -->
        <flux:sidebar
            stashable
            sticky
            class="border-e border-zinc-200 bg-white lg:hidden dark:border-zinc-700 dark:bg-zinc-900"
        >
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <flux:navlist variant="outline">
                <flux:navlist.group>
                    <flux:navlist.item
                        icon="home"
                        :href="route('dashboard')"
                        :current="request()->routeIs('dashboard')"
                        wire:navigate
                    >
                        Dashboard
                    </flux:navlist.item>
                </flux:navlist.group>
            </flux:navlist>
        </flux:sidebar>

        {{ $slot }}

        @fluxScripts
    </body>
</html>
