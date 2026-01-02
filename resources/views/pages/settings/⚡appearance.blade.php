<?php

use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Appearance')] class extends Component {};
?>

<section class="w-full max-w-lg">
    <flux:radio.group x-data variant="segmented" x-model="$flux.appearance">
        <flux:radio value="light" icon="sun">Light</flux:radio>
        <flux:radio value="dark" icon="moon">Dark</flux:radio>
        <flux:radio value="system" icon="computer-desktop">System</flux:radio>
    </flux:radio.group>
</section>
