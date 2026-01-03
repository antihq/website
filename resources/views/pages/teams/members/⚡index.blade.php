<?php

use App\Models\Team;
use App\Models\TeamInvitation as ModelsTeamInvitation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Jetstream\Events\AddingTeamMember;
use Laravel\Jetstream\Events\InvitingTeamMember;
use Laravel\Jetstream\Events\TeamMemberAdded;
use Laravel\Jetstream\Events\TeamMemberRemoved;
use Laravel\Jetstream\Features;
use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\Mail\TeamInvitation;
use Laravel\Jetstream\Rules\Role;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    public Team $team;

    public $email = '';

    public $role = '';

    public function addMember()
    {
        $this->resetErrorBag();

        $this->authorize('addTeamMember', $this->team);

        $this->validateMember();

        if (Features::sendsTeamInvitations()) {
            InvitingTeamMember::dispatch($this->team, $this->email, $this->role);

            $invitation = $this->team->teamInvitations()->create([
                'email' => $this->pull('email'),
                'role' => $this->pull('role'),
            ]);

            Mail::to($invitation->email)->send(new TeamInvitation($invitation));
        } else {
            $newTeamMember = Jetstream::findUserByEmailOrFail($this->pull('email'));

            AddingTeamMember::dispatch($this->team, $newTeamMember);

            $this->team->users()->attach($newTeamMember, ['role' => $this->pull('role')]);

            TeamMemberAdded::dispatch($this->team, $newTeamMember);
        }
    }

    public function cancelInvitation($invitationId)
    {
        if (! empty($invitationId)) {
            ModelsTeamInvitation::whereKey($invitationId)
                ->where('team_id', $this->team->id)
                ->delete();
        }
    }

    public function removeMember($userId)
    {
        $user = Jetstream::findUserByIdOrFail($userId);

        $this->authorize('removeTeamMember', $this->team);

        $this->ensureUserDoesNotOwnTeam($user);

        $this->team->removeUser($user);

        TeamMemberRemoved::dispatch($this->team, $user);
    }

    public function leave()
    {
        $this->ensureUserDoesNotOwnTeam($this->user);

        $this->team->removeUser($this->user);

        return $this->redirectRoute('dashboard');
    }

    #[Computed]
    public function user()
    {
        return Auth::user();
    }

    protected function validateMember(): void
    {
        if (Features::sendsTeamInvitations()) {
            $this->validateWithInvitations();
        } else {
            $this->validateWithoutInvitations();
        }
    }

    protected function validateWithInvitations(): void
    {
        Validator::make(
            [
                'email' => $this->email,
                'role' => $this->role,
            ],
            $this->memberRulesWithInvitations(),
            [
                'email.unique' => 'This user has already been invited to the team.',
            ],
        )
            ->after($this->ensureUserIsNotAlreadyOnTeam())
            ->validateWithBag('addTeamMember');
    }

    protected function validateWithoutInvitations(): void
    {
        Validator::make(
            [
                'email' => $this->email,
                'role' => $this->role,
            ],
            $this->memberRulesWithoutInvitations(),
            [
                'email.exists' => 'We were unable to find a registered user with this email address.',
            ],
        )
            ->after($this->ensureUserIsNotAlreadyOnTeam())
            ->validateWithBag('addTeamMember');
    }

    protected function memberRulesWithInvitations(): array
    {
        return array_filter([
            'email' => [
                'required',
                'email',
                Rule::unique(Jetstream::teamInvitationModel())->where(function ($query) {
                    $query->where('team_id', $this->team->id);
                }),
            ],
            'role' => Jetstream::hasRoles() ? ['required', 'string', new Role] : null,
        ]);
    }

    protected function memberRulesWithoutInvitations(): array
    {
        return array_filter([
            'email' => ['required', 'email', 'exists:users'],
            'role' => Jetstream::hasRoles() ? ['required', 'string', new Role] : null,
        ]);
    }

    protected function ensureUserIsNotAlreadyOnTeam(): Closure
    {
        return function ($validator) {
            $validator
                ->errors()
                ->addIf($this->team->hasUserWithEmail($this->email), 'email', 'This user already belongs to the team.');
        };
    }

    protected function ensureUserDoesNotOwnTeam(User $teamMember): void
    {
        if ($teamMember->id === $this->team->owner->id) {
            $this->addError('team', 'You may not leave a team that you created.');
        }
    }
};
?>

<section class="mx-auto max-w-6xl space-y-8">
    <flux:heading size="lg">Team members</flux:heading>

    <div class="space-y-14">
        @if (Gate::check('addTeamMember', $team))
            <div class="space-y-8">
                <header>
                    <flux:heading>Add team member</flux:heading>
                    <flux:text class="mt-1">
                        @if (Features::sendsTeamInvitations())
                            Add a new team member to your team, allowing them to collaborate with you.
                        @else
                                Add a new team member to your team by their email address.
                        @endif
                    </flux:text>
                </header>

                <form wire:submit="addMember" class="w-full max-w-sm space-y-8">
                    <flux:field>
                        <flux:label>Email</flux:label>
                        <flux:input wire:model="email" type="email" required autofocus placeholder="john@example.com" />
                        <flux:error name="email" />
                    </flux:field>

                    @if (\Laravel\Jetstream\Jetstream::hasRoles())
                        <flux:field>
                            <flux:label>Role</flux:label>
                            <flux:select wire:model="role" placeholder="Select a role">
                                @foreach (\Laravel\Jetstream\Jetstream::$roles as $key => $role)
                                    <flux:select.option value="{{ $key }}">{{ $role->name }}</flux:select.option>
                                @endforeach
                            </flux:select>
                            <flux:error name="role" />
                        </flux:field>
                    @endif

                    <div class="flex items-center gap-4">
                        <div class="flex items-center justify-end">
                            <flux:button variant="primary" type="submit" class="w-full">Add Member</flux:button>
                        </div>
                    </div>
                </form>
            </div>
        @endif

        @if (Features::sendsTeamInvitations() && $team->teamInvitations->isNotEmpty())
            <div class="space-y-6">
                <header class="space-y-1">
                    <flux:heading>Pending invitations</flux:heading>
                    <flux:text>These people have been invited to your team and haven't accepted yet.</flux:text>
                </header>

                <div class="max-w-3xl divide-y divide-zinc-100 text-zinc-950 dark:divide-white/5 dark:text-white">
                    @foreach ($team->teamInvitations as $invitation)
                        <div class="flex items-center justify-between gap-4 py-4">
                            <div class="flex min-w-0 items-center gap-2">
                                <flux:avatar circle size="xs" />
                                <flux:heading size="sm">{{ $invitation->email }}</flux:heading>
                            </div>

                            <div class="flex min-w-fit justify-end">
                                @if (\Laravel\Jetstream\Jetstream::hasRoles())
                                    <flux:text class="text-[13px]">
                                        {{ \Laravel\Jetstream\Jetstream::findRole($invitation->role)?->name }}
                                    </flux:text>
                                @endif
                            </div>

                            <div class="flex min-w-fit justify-end">
                                @if (Gate::check('removeTeamMember', $team))
                                    <flux:button
                                        wire:click="cancelInvitation({{ $invitation->id }})"
                                        variant="subtle"
                                        size="sm"
                                        icon="x-mark"
                                        inset="top bottom"
                                    />
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="space-y-8">
            <header class="space-y-1">
                <flux:heading>Team members</flux:heading>
                <flux:text>All team members that currently have access to this team.</flux:text>
            </header>

            <div class="flex flex-col gap-3">
                @foreach ($team->users as $member)
                    <flux:card class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            @if ($member->profile_photo_path)
                                <flux:avatar circle src="{{ $member->profile_photo_url }}" />
                            @else
                                <flux:profile circle avatar:name="{{ $member->name }}" :chevron="false" />
                            @endif

                            <div>
                                <div class="flex items-center gap-2">
                                    <flux:heading size="sm">{{ $member->name }}</flux:heading>
                                    @if ($member->id === $team->owner->id)
                                        <flux:badge size="sm" color="zinc">Owner</flux:badge>
                                    @elseif (\Laravel\Jetstream\Jetstream::hasRoles())
                                        <flux:badge size="sm" color="zinc">
                                            {{ \Laravel\Jetstream\Jetstream::findRole($member->membership->role)?->name }}
                                        </flux:badge>
                                    @endif
                                </div>
                                <flux:text class="text-sm">{{ $member->email }}</flux:text>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            @if ($member->id !== $team->owner->id && \Laravel\Jetstream\Jetstream::hasRoles() && Gate::check('updateTeamMember', $team))
                                <livewire:member :team="$team" :member="$member" key="member-{{ $member->id }}" />
                            @endif

                            @if ($member->id !== $team->owner->id && Gate::check('removeTeamMember', $team))
                                <flux:button
                                    wire:click="removeMember({{ $member->id }})"
                                    variant="ghost"
                                    size="sm"
                                    icon="trash"
                                    tooltip="Remove member"
                                />
                            @endif
                        </div>
                    </flux:card>
                @endforeach
            </div>
        </div>

        @if ($team->owner->id !== $this->user->id)
            <flux:separator />

            <div>
                <flux:heading>Leave team</flux:heading>
                <flux:text class="mb-6">Are you sure you want to leave this team?</flux:text>

                <flux:modal.trigger name="leave-team">
                    <flux:button variant="danger">Leave team</flux:button>
                </flux:modal.trigger>

                <flux:modal name="leave-team" class="min-w-[22rem]">
                    <div class="space-y-6">
                        <div>
                            <flux:heading size="lg">Leave team?</flux:heading>
                            <flux:text class="mt-2">
                                <p>You're about to leave this team.</p>
                                <p>You'll lose access to all team resources.</p>
                            </flux:text>
                        </div>
                        <div class="flex gap-2">
                            <flux:spacer />
                            <flux:modal.close>
                                <flux:button variant="ghost">Cancel</flux:button>
                            </flux:modal.close>
                            <flux:button wire:click="leave" variant="danger">Leave team</flux:button>
                        </div>
                    </div>
                </flux:modal>
            </div>
        @endif
    </div>
</section>
