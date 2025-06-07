<x-layouts.marketing title="The Terrific Software Company">
    <main class="min-h-screen flex flex-col">
        <x-gradient class="relative flex-1 flex flex-col justify-center">
            <div class="absolute inset-2 rounded-4xl bg-white/80"></div>
            <x-container>
                <div id="call-to-action" class="relative pt-20 pb-16 text-center sm:py-24">
                    <hgroup>
                        <p class="mt-6 text-3xl font-medium tracking-tight text-zinc-950 sm:text-5xl">
                            Just shipping things
                            <br>
                            that might work.
                        </p>
                    </hgroup>
                </div>

                <x-plus-grid class="pb-16">
                    <x-plus-grid.row>
                        <div class="grid grid-cols-2 gap-y-10 pb-6 lg:grid-cols-6 lg:gap-8">
                            <div class="col-span-2 flex">
                                <x-plus-grid.item class="pt-6 lg:pb-6">
                                    <x-logo class="h-9" />
                                </x-plus-grid.item>
                            </div>
                            <div class="col-span-2 grid grid-cols-2 gap-x-8 gap-y-12 lg:col-span-4 lg:grid-cols-subgrid lg:pt-6">
                                <x-sitemap
                                    heading="Research"
                                    :links="[
                                        ['href' => 'https://github.com/terrific-mx/headshot', 'text' => 'Headshot'],
                                        ['href' => 'https://github.com/terrific-mx/feedback', 'text' => 'Feedback'],
                                        ['href' => 'https://github.com/terrific-mx/forms', 'text' => 'Forms'],
                                    ]"
                                />
                                <x-sitemap
                                    heading="Product"
                                    :links="[
                                        ['href' => 'https://fotoprofesional.com.mx', 'text' => 'Foto Profesional']
                                    ]"
                                />
                            </div>
                        </div>
                    </x-plus-grid.row>
                    <x-plus-grid.row class="flex justify-between">
                        <div>
                            <x-plus-grid.item class="py-3">
                                <div id="copyright" class="text-sm/6 text-zinc-950 font-medium">
                                    by <a href="https://x.com/@oliverservinX" class="hover:text-zinc-950/75">@oliverservinX</a>
                                </div>
                            </x-plus-grid.item>
                        </div>
                        <div class="flex">
                            {{-- <x-plus-grid.item class="flex items-center gap-8 py-3"> --}}
                                {{-- Social links --}}
                            {{-- </x-plus-grid.item> --}}
                        </div>
                    </x-plus-grid.row>
                </x-plus-grid>
            </x-container>
        </x-gradient>
    </main>
</x-layouts.marketing>
