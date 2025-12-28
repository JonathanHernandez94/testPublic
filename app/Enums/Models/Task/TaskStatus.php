<?php

namespace App\Enums\Models\Task;

enum TaskStatus: int
{
    case BLOCKED = 1;
    case DONE = 2;
    case REVIEW = 3;
    case IN_PROGRESS = 4;
    case TO_DO = 5;
    case BACKLOG = 6;

    public function title(): string
    {
        return match ($this) {
            self::BLOCKED => 'Blocked',
            self::DONE => 'Done',
            self::REVIEW => 'Review',
            self::IN_PROGRESS => 'In Progress',
            self::TO_DO => 'To Do',
            self::BACKLOG => 'Backlog',
        };
    }
}
