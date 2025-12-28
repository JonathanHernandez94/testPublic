<?php

namespace Database\Seeders;

use App\Enums\Authorization\Role;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * @throws FileNotFoundException
     */
    public function run(): void
    {
        $json = File::get(database_path('seeders/preset_users.json'));
        $usersPreset = json_decode($json, true);

        $organizationCount = 2;

        for ($i = 0; $i < $organizationCount; $i++) {
            $organization = Organization::factory()->create();

            $pm = User::factory()->create([
                'name' => $usersPreset[$i][Role::PM->title()]['name'],
                'email' => $usersPreset[$i][Role::PM->title()]['email'],
            ]);
            $pm->organizations()->attach($organization->id, ['role' => Role::PM]);

            $admin = User::factory()->create([
                'name' => $usersPreset[$i][Role::ADMIN->title()]['name'],
                'email' => $usersPreset[$i][Role::ADMIN->title()]['email']
            ]);
            $admin->organizations()->attach($organization->id, ['role' => Role::ADMIN]);

            $member = User::factory()->create([
                'name' => $usersPreset[$i][Role::MEMBER->title()]['name'],
                'email' => $usersPreset[$i][Role::MEMBER->title()]['email']
            ]);
            $member->organizations()->attach($organization->id, ['role' => Role::MEMBER]);

            User::factory(17)->create()->each(function ($user) use ($organization) {
                $user->organizations()->attach($organization->id, ['role' => Role::MEMBER]);
            });
        }
    }
}
