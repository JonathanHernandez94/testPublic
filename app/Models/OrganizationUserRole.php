<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OrganizationUserRole extends Pivot
{
    protected $table = 'organization_users';

}
