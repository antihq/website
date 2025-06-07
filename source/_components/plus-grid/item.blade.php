<div {{ $attributes->class('group/item relative') }}">
    <x-plus-grid.icon
        placement="top left"
        class="hidden group-first/item:block"
    />
    <x-plus-grid.icon placement="top right" />
    <x-plus-grid.icon
        placement="bottom left"
        class="hidden group-first/item:group-last/row:block"
    />
    <x-plus-grid.icon
        placement="bottom right"
        class="hidden group-last/row:block"
    />
    {{ $slot }}
</div>
