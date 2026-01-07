<?php

use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

it('updates api token permissions', function () {
    if (! Features::hasApiFeatures()) {
        $this->markTestSkipped('API support is not enabled.');
    }

    actingAs($user = User::factory()->withPersonalTeam()->create());

    $token = $user->tokens()->create([
        'name' => 'Test Token',
        'token' => Str::random(40),
        'abilities' => ['create', 'read'],
    ]);

    Livewire::test('api-token', ['token' => $token])
        ->set([
            'permissions' => [
                'delete',
                'missing-permission',
            ],
        ])->call('update');

    expect($user->fresh()->tokens->first()->can('delete'))->toBeTrue();
    expect($user->fresh()->tokens->first()->can('read'))->toBeFalse();
    expect($user->fresh()->tokens->first()->can('missing-permission'))->toBeFalse();
});
