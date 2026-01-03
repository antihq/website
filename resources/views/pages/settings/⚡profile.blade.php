<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Profile')] class extends Component
{
    public string $name = '';

    public string $email = '';

    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id),
            ],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
};
?>

<section class="mx-auto max-w-6xl space-y-8">
    <flux:heading size="lg">Profile</flux:heading>

    <div class="space-y-14">
        <div class="space-y-8">
            <header>
                <flux:heading>Profile information</flux:heading>
                <flux:text class="mt-1">Update your account's profile information and email address.</flux:text>
            </header>

            <form wire:submit="updateProfileInformation" class="w-full max-w-lg space-y-8">
                <flux:input wire:model="name" :label="'Name'" type="text" size="sm" required autofocus autocomplete="name" />

                <div>
                    <flux:input wire:model="email" :label="'Email'" type="email" size="sm" required autocomplete="email" />

                    @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail &&! auth()->user()->hasVerifiedEmail())
                        <div>
                            <flux:text class="mt-4">
                                Your email address is unverified.

                                <flux:link class="cursor-pointer text-sm" wire:click.prevent="resendVerificationNotification">
                                    Click here to re-send the verification email.
                                </flux:link>
                            </flux:text>

                            @if (session('status') === 'verification-link-sent')
                                <flux:text class="!dark:text-green-400 mt-2 font-medium !text-green-600">
                                    A new verification link has been sent to your email address.
                                </flux:text>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="flex items-center gap-4">
                    <div class="flex items-center justify-end">
                        <flux:button variant="primary" type="submit" class="w-full" size="sm">Save</flux:button>
                    </div>

                    <x-action-message class="me-3" on="profile-updated">Saved.</x-action-message>
                </div>
            </form>
        </div>

        <div class="space-y-6">
            <livewire:settings.delete-user-form />
        </div>
    </div>
</section>
