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

<div class="flex items-center justify-between gap-4 py-4">
    <div class="flex min-w-0 items-center gap-2">
        @if ($member->profile_photo_path)
            <flux:avatar circle size="xs" src="{{ $member->profile_photo_url }}" />
        @else
            <flux:profile circle avatar:name="{{ $member->name }}" :chevron="false" size="xs" />
        @endif
        <flux:heading size="sm">{{ $member->name }}</flux:heading>
    </div>

    <div class="flex min-w-fit justify-end">
        <flux:text class="text-[13px]">
            {{ $member->email }}
        </flux:text>
    </div>

    <div class="flex min-w-fit justify-end">
        @if ($member->id === $team->owner->id)
            <flux:text class="text-[13px]">Owner</flux:text>
        @elseif (\Laravel\Jetstream\Jetstream::hasRoles())
            <flux:text class="text-[13px]">
                {{ \Laravel\Jetstream\Jetstream::findRole($member->membership->role)?->name }}
            </flux:text>
        @endif
    </div>

    <div class="flex min-w-fit justify-end">
        @if ($member->id !== $team->owner->id && \Laravel\Jetstream\Jetstream::hasRoles() && Gate::check('updateTeamMember', $team))
            <flux:dropdown align="end">
                <flux:button size="sm" variant="subtle" icon="pencil" tooltip="Change role" inset="top bottom" />

                <flux:menu>
                    <flux:menu.heading>Change role</flux:menu.heading>
                    @foreach (\Laravel\Jetstream\Jetstream::$roles as $key => $role)
                        @if ($member->teamRole($team)->key === $key)
                            <flux:menu.item wire:click="updateRole('{{ $key }}')" icon="check">
                                {{ $role->name }}
                            </flux:menu.item>
                        @else
                            <flux:menu.item wire:click="updateRole('{{ $key }}')">{{ $role->name }}</flux:menu.item>
                        @endif
                    @endforeach
                </flux:menu>
            </flux:dropdown>
        @endif

        @if ($member->id !== $team->owner->id && Gate::check('removeTeamMember', $team))
            <flux:button
                wire:click="$parent.removeMember({{ $member->id }})"
                variant="subtle"
                size="sm"
                icon="x-mark"
                inset="top bottom"
            />
        @endif
    </div>
</div>
