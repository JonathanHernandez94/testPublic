<?php

namespace App\Models;

use App\Enums\Authorization\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
    ];

    public function organizations(): BelongsToMany
    {
        return $this->belongsToMany(Organization::class, 'organization_users')
            ->using(OrganizationUserRole::class)
            ->withPivot('role')
            ->withTimestamps();
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'project_members')
            ->withTimestamps();
    }

    /**
     * Assuming a user can have many tasks
     */
    public function assignedTasks(): HasMany
    {
        return $this->hasMany(Task::class, 'assignee_id');
    }

    /**
     * Assuming a user can create many tasks
     */
    public function createdTasks(): HasMany
    {
        return $this->hasMany(Task::class, 'created_by');
    }

    /**
     * Assuming a user can modify many tasks
     */
    public function modifiedTasks(): HasMany
    {
        return $this->hasMany(Task::class, 'updated_by');
    }

    /**
     * Assuming that the user is always in the context of an Organization since we were logged with a JWT with orgId
     */
    public function getRole(?Organization $organization = null): ?int
    {
        return $this->organizations()
            ->where('id', $organization?->id ?? Auth::guard('api')->getOrganizationId())
            ->first()
            ?->pivot
            ?->role
            ->value;
    }

    public function isInOrganization(Organization $organization): bool
    {
        return $this->organizations()
            ->where('id', $organization->id)
            ->exists();
    }

    public function isMemberOfProject(Project $project): bool
    {
        return $this->projects()
            ->where('id', $project->id)
            ->exists();
    }
}
