<?php

namespace App\Enums\Models\Task;

enum TaskPriority: int
{
    case CRITICAL = 1;
    case HIGH = 2;
    case MEDIUM = 3;
    case LOW = 4;

    public function title(): string
    {
        return match ($this) {
            self::CRITICAL => 'Critical',
            self::HIGH => 'High',
            self::MEDIUM => 'Medium',
            self::LOW => 'Low',
        };
    }
}
