<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="dark antialiased lg:bg-zinc-100 dark:bg-zinc-900 dark:lg:bg-zinc-950"
>
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-900 dark:lg:bg-zinc-950">
        <flux:header class="border-zinc-200 lg:border-b dark:border-zinc-700">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" size="sm" />

            <flux:navbar class="-mb-px max-lg:hidden">
                <flux:navbar.item :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                    Dashboard
                </flux:navbar.item>
            </flux:navbar>

            <flux:spacer />

            <!-- Desktop User Menu -->
            <flux:dropdown position="top" align="end">
                <flux:profile
                    class="cursor-pointer"
                    :initials="auth()->user()->initials()"
                    avatar:size="xs"
                    :chevron="false"
                />

                <flux:menu>
                    <flux:menu.group heading="Account">
                        <flux:menu.item :href="route('profile.edit')" icon="user" icon:variant="micro" wire:navigate>
                            Profile
                        </flux:menu.item>
                        <flux:menu.item
                            :href="route('user-password.edit')"
                            icon="key"
                            icon:variant="micro"
                            wire:navigate
                        >
                            Password
                        </flux:menu.item>
                        <flux:menu.item
                            :href="route('two-factor.show')"
                            icon="shield-check"
                            icon:variant="micro"
                            wire:navigate
                        >
                            Two-Factor Auth
                        </flux:menu.item>
                        <flux:menu.item
                            :href="route('appearance.edit')"
                            icon="adjustments-horizontal"
                            icon:variant="micro"
                            wire:navigate
                        >
                            Appearance
                        </flux:menu.item>
                    </flux:menu.group>

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            icon:variant="micro"
                            class="w-full"
                        >
                            Log Out
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

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
