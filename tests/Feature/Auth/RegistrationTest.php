<?php

use App\Models\User;

test('registration screen can be rendered', function () {
    $response = $this->get(route('register'));

    $response->assertStatus(200);
});

test('new users can register', function () {
    $response = $this->post(route('register.store'), [
        'name' => 'John Doe',
        'email' => 'test@example.com',
        'password' => 'password',
    ]);

    $response->assertSessionHasNoErrors()
        ->assertRedirect(route('dashboard', absolute: false));

    $this->assertAuthenticated();
});

test('new users get a personal team created', function () {
    $response = $this->post(route('register.store'), [
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'password' => 'password',
    ]);

    $response->assertSessionHasNoErrors();

    $this->assertDatabaseHas('teams', [
        'name' => "Jane Doe's Team",
        'personal_team' => true,
    ]);

    $user = User::where('email', 'jane@example.com')->first();
    expect($user->personalTeam())->not->toBeNull()
        ->and($user->personalTeam()->name)->toBe("Jane Doe's Team")
        ->and($user->current_team_id)->toBe($user->personalTeam()->id);
});
