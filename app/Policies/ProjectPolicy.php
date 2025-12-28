<?php

namespace App\Policies;

use App\Authentication\JwtGuard;
use App\Authorization\Role;
use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class ProjectPolicy
{
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
        $isProjectMember = $project->users()->where('id', $user->id)->count() > 0;

        $role = $user->organizations()
            ->where('id', Auth::guard('api')->getOrganizationId())
            ->pivot
            ->role
            ->value;

        return match ($role) {
            Role::ADMIN->value => true,
            Role::PM->value, Role::MEMBER->value => $isProjectMember
        };
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        $role = $user->organizations()
            ->where('id', Auth::guard('api')->getOrganizationId())
            ->pivot
            ->role
            ->value;

        return match ($role) {
            Role::ADMIN->value, Role::PM->value => true,
            Role::MEMBER->value => false
        };
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Project $project): bool
    {
        $isProjectMember = $project->users()->where('id', $user->id)->count() > 0;

        $role = $user->organizations()
            ->where('id', Auth::guard('api')->getOrganizationId())
            ->pivot
            ->role
            ->value;

        return match ($role) {
            Role::ADMIN->value => true,
            Role::PM->value => $isProjectMember, // Assuming only one PM per project
            Role::MEMBER->value => false
        };
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Project $project): bool
    {
        $isProjectMember = $project->users()->where('id', $user->id)->count() > 0;

        $role = $user->organizations()
            ->where('id', Auth::guard('api')->getOrganizationId())
            ->pivot
            ->role
            ->value;

        return match ($role) {
            Role::ADMIN->value => true,
            Role::PM->value => $isProjectMember, // Assuming only one PM per project
            Role::MEMBER->value => false
        };
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
