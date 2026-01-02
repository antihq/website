<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('pages::teams.show')
        ->assertStatus(200);
});
