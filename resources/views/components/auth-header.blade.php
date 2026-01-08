@props([
    'title',
    'description',
])

<div class="flex w-full flex-col space-y-8">
    <flux:heading size="xl">{{ $title }}</flux:heading>
    @if (! empty($description))
        <flux:text>{{ $description }}</flux:text>
    @endif
</div>
