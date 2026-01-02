<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('pages::teams.create')
        ->assertStatus(200);
});
