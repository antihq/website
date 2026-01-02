<?php

use App\Models\User;
use Laravel\Jetstream\Features;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

test('api tokens can be created', function () {
    if (! Features::hasApiFeatures()) {
        $this->markTestSkipped('API support is not enabled.');
    }

    actingAs($user = User::factory()->withPersonalTeam()->create());

    Livewire::test('pages::api-tokens.index')
        ->set([
            'name' => 'Test Token',
            'permissions' => [
                'read',
                'update',
            ]])->call('create');

    expect($user->fresh()->tokens)->toHaveCount(1);
    expect($user->fresh()->tokens->first()->name)->toEqual('Test Token');
    expect($user->fresh()->tokens->first()->can('read'))->toBeTrue();
    expect($user->fresh()->tokens->first()->can('delete'))->toBeFalse();
});
