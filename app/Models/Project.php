<?php

namespace App\Models;

use App\Enums\Models\Project\ProjectVisibility;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $casts = [
        'visibility' => ProjectVisibility::class,
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_members');
    }

    /**
     * Assuming a project belongs to only one 1 organization
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     *  Assuming a project may have multiple tasks
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function isPublic(): bool
    {
        return $this->visibility === ProjectVisibility::PUBLIC->value;
    }

}
