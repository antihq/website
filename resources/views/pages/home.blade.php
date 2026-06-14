<x-layouts::auth title="Welcome">
    <h1 class="font-bold">the anti headquarters software company</h1>

    <h2 class="mt-6 font-bold">projects</h2>

    <ul class="lowercase ml-4">
        <li><flux:link href="https://2026-05-18-mayfly.antihq.com/" target="_blank">Mayfly</flux:link></li>
        <li><flux:link href="https://2026-05-07-tuner.antihq.com/" target="_blank">Tuner</flux:link></li>
        <li><flux:link href="https://2026-05-04-glance.antihq.com/" target="_blank">Glance</flux:link></li>
        <li><flux:link href="{{ route('vault') }}">Vault</flux:link></li>
    </ul>

    <dl class="mt-6">
        <dt class="font-bold">contact</dt>
        <dd class="ml-4"><flux:link href="mailto:oliver@antihq.com">oliver@antihq.com</flux:link></dd>
        <dd class="ml-4"><flux:link href="https://x.com/oliverservinX">x.com/oliverservinX</flux:link></dd>
    </dl>
</x-layouts::auth>
