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

        $this->team->users()->updateExistingPivot($this->member->id, [
            'role' => $this->role,
        ]);

        TeamMemberUpdated::dispatch($this->team->fresh(), $this->member);
    }
};
?>

<div>
    {{-- I begin to speak only when I am certain what I will say is not better left unsaid. - Cato the Younger --}}
</div>
