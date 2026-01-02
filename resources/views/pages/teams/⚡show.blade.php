<?php

use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
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

    public function update()
    {
        $this->authorize('update', $this->team);

        $this->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $this->team
            ->fill([
                'name' => $this->name,
            ])
            ->save();

        $this->dispatch('saved');
    }

    public function delete()
    {
        $this->authorize('delete', $this->team);

        if ($this->team->personal_team) {
            throw ValidationException::withMessages([
                'team' => 'You may not delete your personal team.',
            ]);
        }

        $this->team->purge();

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
        <flux:input wire:model="name" label="Team name" type="text" required autofocus />

        <div class="flex items-center gap-4">
            <div class="flex items-center justify-end">
                <flux:button variant="primary" type="submit" class="w-full">Save</flux:button>
            </div>

            <x-action-message class="me-3" on="saved">Saved.</x-action-message>
        </div>
    </form>

    @if (Gate::check('delete', $team) && ! $team->personal_team)
        <div>
            <flux:modal.trigger name="delete">
                <flux:button variant="danger">Delete team</flux:button>
            </flux:modal.trigger>

            <flux:modal name="delete" class="min-w-[22rem]">
                <div class="space-y-6">
                    <div>
                        <flux:heading size="lg">Delete team?</flux:heading>
                        <flux:text class="mt-2">
                            <p>You're about to delete this team.</p>
                            <p>This action cannot be reversed.</p>
                        </flux:text>
                    </div>
                    <div class="flex gap-2">
                        <flux:spacer />
                        <flux:modal.close>
                            <flux:button variant="ghost">Cancel</flux:button>
                        </flux:modal.close>
                        <flux:button wire:click="delete" variant="danger">Delete team</flux:button>
                    </div>
                </div>
            </flux:modal>
        </div>
    @endif
</section>
