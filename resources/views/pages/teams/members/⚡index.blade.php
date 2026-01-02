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

            Mail::to($this->email)->send(new TeamInvitation($invitation));
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

<div>
    {{-- Waste no more time arguing what a good man should be, be one. - Marcus Aurelius --}}
</div>
