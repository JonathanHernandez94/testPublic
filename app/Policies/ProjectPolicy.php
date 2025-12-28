<?php

namespace App\Policies;

use App\Enums\Authorization\Role;
use App\Enums\Models\Project\ProjectVisibility;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProjectPolicy
{
    private function hasFullAccessToModify(User $user, Project $project): bool
    {
        return match ($user->getRole()) {
            Role::ADMIN->value => true,
            Role::PM->value => $user->isMemberOfProject($project), // Assuming only one PM per project
            default => false
        };
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Project $project): bool
    {
        if ($project->isPublic() || $user->isMemberOfProject($project)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return match ($user->getRole()) {
            Role::ADMIN->value, Role::PM->value => true,
            default => false
        };
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Project $project): bool
    {
        return $this->hasFullAccessToModify($user, $project);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Project $project): bool
    {
        return $this->hasFullAccessToModify($user, $project);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Project $project): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Project $project): bool
    {
        return false;
    }
}
