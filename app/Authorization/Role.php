<?php

namespace App\Authorization;

enum Role: int
{
    case ADMIN = 1;
    case PM = 2;
    case MEMBER = 3;

    public function title(): string
    {
        return match ($this) {
            self::ADMIN => 'Organization Admin',
            self::PM => 'Project Manager',
            self::MEMBER => 'Member',
        };
    }
}
