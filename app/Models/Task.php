<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    /**
     * Assuming a task belongs to only one 1 project
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
