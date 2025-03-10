<?php

namespace App\Enum;

use App\Traits\EnumValueTrait;

enum RoleEnum: string
{
    use EnumValueTrait;

    case SUPERADMIN = 'super-admin';
    case ADMIN = 'admin';
    case REGULAR = 'regular';
}
