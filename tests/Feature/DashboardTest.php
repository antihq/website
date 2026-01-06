<?php

use App\Models\User;

it('redirects guests to the login page', function () {
    $this->get('/dashboard')->assertRedirect('/login');
});

it('allows authenticated users to visit the dashboard', function () {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $this->get('/dashboard')->assertStatus(200);
});
