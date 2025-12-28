<?php

namespace App\Enums\Models\Project;

enum ProjectVisibility: int
{
    case PRIVATE = 1;
    case PUBLIC = 2;

    public function title(): string
    {
        return match ($this) {
            self::PRIVATE => 'Private',
            self::PUBLIC => 'Public'
        };
    }
}
