<?php

use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\Contracts\UpdatesTeamNames;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    public Team $team;

    public $name = '';

    public function mount($team)
    {
        $this->name = $team->name;
    }

    public function updateTeamName(UpdatesTeamNames $updater)
    {
        $this->resetErrorBag();

        $updater->update($this->user, $this->team, ['name' => $this->name]);

        $this->dispatch('saved');

        $this->dispatch('refresh-navigation-menu');
    }

    #[Computed]
    public function user()
    {
        return Auth::user();
    }
};
?>

<section class="w-full">
    <form wire:submit="updateTeamName" class="w-full max-w-lg space-y-6">
        <flux:input wire:model="name" :label="'Team Name'" type="text" required autofocus />

        <div class="flex items-center gap-4">
            <div class="flex items-center justify-end">
                <flux:button variant="primary" type="submit" class="w-full">Save</flux:button>
            </div>

            <x-action-message class="me-3" on="saved">Saved.</x-action-message>
        </div>
    </form>
</section>
