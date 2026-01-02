<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('pages::api-tokens.index')
        ->assertStatus(200);
});
