<?php

use App\Models\Team;
use Illuminate\Foundation\Auth\User;
use Laravel\Jetstream\Events\TeamMemberUpdated;
use Laravel\Jetstream\Rules\Role;
use Livewire\Component;

new class extends Component
{
    public Team $team;

    public User $member;

    public $role = '';

    public function mount()
    {
        $this->role = $this->member->teamRole($this->team)->key;
    }

    public function update()
    {
        $this->authorize('updateTeamMember', $this->team);

        $this->validate([
            'role' => ['required', 'string', new Role],
        ]);

        $this->updateRole($this->role);
    }

    public function updateRole(string $role)
    {
        $this->authorize('updateTeamMember', $this->team);

        $this->role = $role;

        $this->team->users()->updateExistingPivot($this->member->id, [
            'role' => $role,
        ]);

        TeamMemberUpdated::dispatch($this->team->fresh(), $this->member);
    }
};
?>

<flux:dropdown align="end">
    <flux:button size="sm" variant="ghost" icon="pencil" tooltip="Change role" />

    <flux:menu>
        <flux:menu.heading>Change role</flux:menu.heading>
        @foreach (\Laravel\Jetstream\Jetstream::$roles as $key => $role)
            @if ($member->teamRole($team)->key === $key)
                <flux:menu.item wire:click="updateRole('{{ $key }}')" icon="check">{{ $role->name }}</flux:menu.item>
            @else
                <flux:menu.item wire:click="updateRole('{{ $key }}')">{{ $role->name }}</flux:menu.item>
            @endif
        @endforeach
    </flux:menu>
</flux:dropdown>
