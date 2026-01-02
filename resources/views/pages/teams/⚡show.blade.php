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

<div>
    {{-- Order your soul. Reduce your wants. - Augustine --}}
</div>
