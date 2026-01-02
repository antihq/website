<?php

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Laravel\Jetstream\Features;
use Laravel\Jetstream\Mail\TeamInvitation;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

it('can update team names', function () {
    actingAs($user = User::factory()->withPersonalTeam()->create());

    Livewire::test('pages::teams.show', ['team' => $user->currentTeam])
        ->set('name', 'Test Team')
        ->call('update');

    expect($user->fresh()->ownedTeams)->toHaveCount(1);
    expect($user->currentTeam->fresh()->name)->toEqual('Test Team');
});

test('teams can be deleted', function () {
    actingAs($user = User::factory()->withPersonalTeam()->create());

    $user->ownedTeams()->save($team = Team::factory()->make([
        'personal_team' => false,
    ]));

    $team->users()->attach(
        $otherUser = User::factory()->create(), ['role' => 'test-role']
    );

    Livewire::test('pages::teams.show', ['team' => $team->fresh()])
        ->call('delete');

    expect($team->fresh())->toBeNull();
    expect($otherUser->fresh()->teams)->toHaveCount(0);
});

test('personal teams cant be deleted', function () {
    actingAs($user = User::factory()->withPersonalTeam()->create());

    Livewire::test('pages::teams.show', ['team' => $user->currentTeam])
        ->call('delete')
        ->assertHasErrors(['team']);

    expect($user->currentTeam->fresh())->not->toBeNull();
});

test('delete modal is shown for non-personal teams', function () {
    actingAs($user = User::factory()->withPersonalTeam()->create());

    $user->ownedTeams()->save($team = Team::factory()->make([
        'personal_team' => false,
    ]));

    Livewire::test('pages::teams.show', ['team' => $team->fresh()])
        ->assertSee('Delete team?', false)
        ->assertSee('You\'re about to delete this team.', false)
        ->assertSee('This action cannot be reversed.', false)
        ->assertSee('Cancel', false)
        ->assertSee('Delete team', false);
});

test('delete modal is not shown for personal teams', function () {
    actingAs($user = User::factory()->withPersonalTeam()->create());

    Livewire::test('pages::teams.show', ['team' => $user->currentTeam])
        ->assertDontSee('Delete Team')
        ->assertDontSee('Delete team?');
});

test('team members can be invited to team', function () {
    if (! Features::sendsTeamInvitations()) {
        $this->markTestSkipped('Team invitations not enabled.');
    }

    Mail::fake();

    actingAs($user = User::factory()->withPersonalTeam()->create());

    Livewire::test('pages::teams.show', ['team' => $user->currentTeam])
        ->set([
            'email' => 'test@example.com',
            'role' => 'admin',
        ])->call('addMember');

    Mail::assertSent(TeamInvitation::class);

    expect($user->currentTeam->fresh()->teamInvitations)->toHaveCount(1);
});

test('team member invitations can be cancelled', function () {
    if (! Features::sendsTeamInvitations()) {
        $this->markTestSkipped('Team invitations not enabled.');
    }

    Mail::fake();

    actingAs($user = User::factory()->withPersonalTeam()->create());

    // Add the team member...
    $component = Livewire::test('pages::teams.show', ['team' => $user->currentTeam])
        ->set([
            'email' => 'test@example.com',
            'role' => 'admin',
        ])->call('addMember');

    $invitationId = $user->currentTeam->fresh()->teamInvitations->first()->id;

    // Cancel the team invitation...
    $component->call('cancelInvitation', $invitationId);

    expect($user->currentTeam->fresh()->teamInvitations)->toHaveCount(0);
});

test('team members can be removed from teams', function () {
    actingAs($user = User::factory()->withPersonalTeam()->create());

    $user->currentTeam->users()->attach(
        $otherUser = User::factory()->create(), ['role' => 'admin']
    );

    $component = Livewire::test('pages::teams.show', ['team' => $user->currentTeam])
        ->call('removeMember', $otherUser->id)
        ->assertHasNoErrors();

    expect($user->currentTeam->fresh()->users)->toHaveCount(0);
});

test('only team owner can remove team members', function () {
    $user = User::factory()->withPersonalTeam()->create();

    $user->currentTeam->users()->attach(
        $otherUser = User::factory()->create(), ['role' => 'admin']
    );

    actingAs($otherUser);

    Livewire::test('pages::teams.show', ['team' => $user->currentTeam])
        ->call('removeMember', $user->id)
        ->assertStatus(403);
});

test('users can leave teams', function () {
    $user = User::factory()->withPersonalTeam()->create();

    $user->currentTeam->users()->attach(
        $otherUser = User::factory()->create(), ['role' => 'admin']
    );

    actingAs($otherUser);

    Livewire::test('pages::teams.show', ['team' => $user->currentTeam])
        ->call('leave');

    expect($user->currentTeam->fresh()->users)->toHaveCount(0);
});

test('team owners cant leave their own team', function () {
    actingAs($user = User::factory()->withPersonalTeam()->create());

    Livewire::test('pages::teams.show', ['team' => $user->currentTeam])
        ->call('leave')
        ->assertHasErrors(['team']);

    expect($user->currentTeam->fresh())->not->toBeNull();
});
