<?php

use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts::site')] class extends Component {
    //
};
?>

<flux:main>
    <div class="flex w-full max-w-sm flex-col gap-12">
        <flux:text class="flex items-center gap-2">
            <flux:link :href="route('home')" wire:navigate>antihq</flux:link>
            /
            <flux:link href="https://x.com/oliverservinX" target="_blank" rel="noreferrer">twitter</flux:link>
            /
            <flux:link href="https://github.com/antihq" target="_blank" rel="noreferrer">github</flux:link>
        </flux:text>

        <div class="flex flex-col gap-2">
            <flux:heading level="2" size="lg">antihq/board</flux:heading>
            <flux:text>
                <flux:link href="https://github.com/antihq/board" target="_blank" rel="noopener noreferrer">
                    A collaborative project management tool with Kanban boards
                </flux:link>.
            </flux:text>
        </div>

        <div class="flex flex-col gap-2">
            <flux:heading level="2" size="lg">antihq/password</flux:heading>
            <flux:text>
                <flux:link href="https://password.antihq.com" target="_blank" rel="noopener noreferrer">
                    A secure password and credit card management application with team collaboration
                </flux:link>.
            </flux:text>
        </div>

        <div class="flex flex-col gap-2">
            <flux:heading level="2" size="lg">antihq/bookkeeping</flux:heading>
            <flux:text>
                <flux:link href="https://github.com/antihq/bookkeeping" target="_blank" rel="noopener noreferrer">
                    A modern Laravel-based personal finance and bookkeeping application
                </flux:link>.
            </flux:text>
        </div>

        <div class="flex flex-col gap-2">
            <flux:heading level="2" size="lg">antihq/poll</flux:heading>
            <flux:text>
                <flux:link href="https://poll.antihq.com/" target="_blank" rel="noopener noreferrer">
                    Polls in emails. Not platform lock-in.
                </flux:link>.
            </flux:text>
        </div>

        <div class="flex flex-col gap-2">
            <flux:heading level="2" size="lg">antihq/livewire-starter-kit</flux:heading>
            <flux:text>
                <flux:link href="https://github.com/antihq/livewire-starter-kit" target="_blank" rel="noopener noreferrer">
                    Production-ready Laravel starter kit with authentication and team management.
                </flux:link>.
            </flux:text>
        </div>
    </div>
</flux:main>
