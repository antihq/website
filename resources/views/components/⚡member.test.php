<?php

use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

it('updates team member roles', function () {
    actingAs($user = User::factory()->withPersonalTeam()->create());

    $user->currentTeam->users()->attach(
        $otherUser = User::factory()->create(), ['role' => 'admin']
    );

    Livewire::test('member', ['team' => $user->currentTeam, 'member' => $otherUser])
        ->set('role', 'editor');

    expect($otherUser->fresh()->hasTeamRole(
        $user->currentTeam->fresh(), 'editor'
    ))->toBeTrue();
});

it('prevents non-owners from updating team member roles', function () {
    $user = User::factory()->withPersonalTeam()->create();

    $user->currentTeam->users()->attach(
        $otherUser = User::factory()->create(), ['role' => 'admin']
    );

    actingAs($otherUser);

    Livewire::test('member', ['team' => $user->currentTeam, 'member' => $otherUser])
        ->set('role', 'editor')
        ->assertStatus(403);

    expect($otherUser->fresh()->hasTeamRole(
        $user->currentTeam->fresh(), 'admin'
    ))->toBeTrue();
});
