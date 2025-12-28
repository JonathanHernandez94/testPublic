<?php

namespace App\Models;

use App\Enums\Models\Project\ProjectStatus;
use App\Enums\Models\Project\ProjectVisibility;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes, HasFactory;
    protected $casts = [
        'visibility' => ProjectVisibility::class,
        'status' => ProjectStatus::class,
    ];

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'status',
        'organization_id'
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
