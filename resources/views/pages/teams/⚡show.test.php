<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

it('can update team names', function () {
    actingAs($user = User::factory()->withPersonalTeam()->create());

    Livewire::test('pages::teams.show', ['team' => $user->currentTeam])
        ->set('name', 'Test Team')
        ->call('updateTeamName');

    expect($user->fresh()->ownedTeams)->toHaveCount(1);
    expect($user->currentTeam->fresh()->name)->toEqual('Test Team');
});
