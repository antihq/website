<?php

use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

it('logs out other browser sessions', function () {
    actingAs(User::factory()->create());

    Livewire::test('pages::sessions.index')
        ->set('password', 'password')
        ->call('logoutOtherBrowserSessions')
        ->assertSuccessful();
});
