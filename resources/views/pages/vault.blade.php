<x-layouts::auth title="Vault">
    <div class="max-w-prose">
        <h1 class="font-bold">vault</h1>

        <p class="mt-6 lowercase">not a new way to manage passwords and credit cards. no ai. no autofill. no bloat. just the necessary — encrypted and out of the way.</p>

        <h2 class="mt-6 font-bold">what it does</h2>

        <ul class="lowercase ml-4 list-disc">
            <li>passwords and cards, encrypted at rest in the db</li>
            <li>it's a web app — open it in any browser, on any device</li>
            <li>solo by default. make a team when you want to share with friends, family, or colleagues</li>
        </ul>

        <p class="mt-6 lowercase">it won't generate your 2fa codes. pair it with <flux:link href="https://2fas.com/" target="_blank">2fas</flux:link> — that's what I use.</p>

        <p class="mt-6 lowercase">no autofill built in either. pair it with your browser or os password manager (chrome, macos) for quick fills — vault stays the source of truth. that's how I handle the passwords I type all day: change it in vault first, then mirror it to the built-in, so I'm not opening vault every time.</p>

        <dl class="mt-6">
            <dt class="font-bold">is it secure?</dt>
            <dd class="ml-4 lowercase">the db holds your secrets encrypted; they're decrypted with the app key. so yeah — kinda secure. I run my own passwords on it.</dd>
        </dl>

        <p class="mt-6 lowercase">use it if you want, and if you trust me. there are real alternatives — <flux:link href="https://bitwarden.com/" target="_blank">bitwarden</flux:link> is free, <flux:link href="https://1password.com/" target="_blank">1password</flux:link> is paid and polished. I built vault for myself first, but it's open for you to try and use as much as you want.</p>

        <p class="mt-6"><flux:link href="https://vault.antihq.com/" target="_blank">try vault →</flux:link></p>
    </div>
</x-layouts::auth>
