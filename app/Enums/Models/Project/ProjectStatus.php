<?php

namespace App\Enums\Models\Project;

enum ProjectStatus: int
{
    case COMPLETED = 1;
    case ON_HOLD = 2;
    case ACTIVE = 3;
    case PLANNING = 4;

    public function title(): string
    {
        return match ($this) {
            self::PLANNING => 'Planning',
            self::ACTIVE => 'Active',
            self::ON_HOLD => 'ON Hold',
            self::COMPLETED => 'Completed',
        };
    }
}
