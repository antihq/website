<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()->withoutTwoFactor()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $user->ownedTeams()->save(
            Team::forceCreate([
                'user_id' => $user->id,
                'name' => $user->name . "'s Team",
                'personal_team' => true,
            ])
        );

        $team = $user->personalTeam();

        $user->teams()->attach($team, ['role' => 'owner']);
        $user->switchTeam($team);
    }
}
