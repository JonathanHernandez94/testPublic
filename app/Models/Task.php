<?php

namespace App\Models;

use App\Enums\Models\Task\TaskPriority;
use App\Enums\Models\Task\TaskStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $casts = [
        'status' => TaskStatus::class,
        'priority' => TaskPriority::class,
    ];

    /**
     * Assuming a task belongs to only one 1 project
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Assuming a task belongs to only one 1 assignee
     */
    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    /**
     * Assuming a task belongs to only one 1 creator
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Assuming a task belongs to only one 1 last modifier
     */
    public function modifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function isAssignee(User $user): bool
    {
        return $this->assignee_id === $user->id;
    }

    protected static function booted(): void
    {
        static::saving(function (Task $task) {
            if ($task->assignee_id) {
                /** @var User $user */
                $user = User::FindorFail($task->assignee_id);

                if (!$user->isMemberOfProject($task->project->id)) {
                    throw new \Exception(
                        'Assignee does not belong to the Team that own this Task.'
                    );
                }
            }
        });
    }
}
