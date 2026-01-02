<?php

use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\Events\AddingTeam;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    public $name = '';

    public function create()
    {
        $this->authorize('create', Team::class);

        $this->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        AddingTeam::dispatch($this->user);

        $this->user->switchTeam($this->user->ownedTeams()->create([
            'name' => $this->name,
            'personal_team' => false,
        ]));

        return $this->redirectRoute('dashboard');
    }

    #[Computed]
    public function user()
    {
        return Auth::user();
    }
};
?>

<section class="w-full">
    <form wire:submit="update" class="w-full max-w-lg space-y-6">
        <flux:input wire:model="name" label="Team Name" type="text" required autofocus />

        <div class="flex items-center gap-4">
            <div class="flex items-center justify-end">
                <flux:button variant="primary" type="submit" class="w-full">Create</flux:button>
            </div>
        </div>
    </form>
</section>
