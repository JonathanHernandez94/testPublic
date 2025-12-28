<?php

namespace App\Models;

use App\Enums\Authorization\Role;
use Illuminate\Database\Eloquent\Relations\Pivot;

class OrganizationUserRole extends Pivot
{
    protected $table = 'organization_users';

    protected $casts = [
        'role' => Role::class,
    ];
}
