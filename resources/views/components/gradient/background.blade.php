<div class="relative mx-auto max-w-7xl">
    <div {{
        $attributes->class([
            'absolute -top-44 -right-60 h-60 w-[36rem] transform-gpu md:right-0',
            'bg-gradient-to-br from-[#f6d365] from-[28%] via-[#fda085] via-[70%] to-[#ff2400]',
            'rotate-[-10deg] rounded-full blur-3xl',
        ])
    }}>{{ $slot }}</div>
</div>
