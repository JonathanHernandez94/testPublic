<?php

namespace App\Policies;

use App\Enums\Authorization\Role;
use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    private function hasAccessToModify(User $user, Task $task): bool
    {
        return match ($user->getRole()) {
            Role::ADMIN->value => true,
            Role::PM->value => $user->isMemberOfProject($task->project),
            Role::MEMBER->value => $task->isAssignee($user),
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
    public function view(User $user, Task $task): bool
    {
        return $this->hasAccessToModify($user, $task);
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
    public function update(User $user, Task $task): bool
    {
        return $this->hasAccessToModify($user, $task);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Task $task): bool
    {
        return match ($user->getRole()) {
            Role::ADMIN->value => true,
            Role::PM->value => $user->isMemberOfProject($task->project),
            default => false
        };
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Task $task): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Task $task): bool
    {
        return false;
    }
}
