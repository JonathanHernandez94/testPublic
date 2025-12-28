<?php

namespace Database\Seeders;

use App\Enums\Authorization\Role;
use App\Models\Organization;
use App\Models\Project;
use App\Models\User;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * @throws FileNotFoundException
     */
    public function run(): void
    {
        $organizationCount = 2;
        $projectsCount = 3;
        $this->createUsersProjectsForOrganizations($organizationCount, $projectsCount);
    }

    private function getUsersMock(): array
    {
        return json_decode(File::get(database_path('seeders/preset_users.json')), true);
    }

    private function createAttachUserProjectToOrganization(array $users, Organization $organization, $projectsCount): void
    {
        foreach ([Role::PM, Role::ADMIN, Role::MEMBER] as $role) {
            $userData = $users[$role->title()];
            $user = User::factory()->create([
                'name'  => $userData['name'],
                'email' => $userData['email'],
            ]);
            $user->organizations()->attach($organization->id, ['role' => $role->value]);
            if($role->value === Role::PM->value) {
                $this->createProjectWithPMForOrganization($organization, $user->id ,$projectsCount);
            }
        }
    }

    private function createUsersProjectsForOrganizations(?int $organizationsCount = 1, $projectsCount = 1): void
    {
        $users = $this->getUsersMock();
        for ($i = 0; $i < $organizationsCount; $i++) {
            $organization = Organization::factory()->create();
            $this->createAttachUserProjectToOrganization($users[$i], $organization, $projectsCount);
        }
    }

    private function createProjectWithPMForOrganization(Organization $organization, int $pmUserId, $projectsCount): void
    {
        Project::factory()
            ->count($projectsCount)
            ->create([
                'organization_id' => $organization->id,
                'project_manager_id' => $pmUserId,
            ]);
    }
}
