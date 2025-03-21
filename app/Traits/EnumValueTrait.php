<?php

namespace App\Traits;

trait EnumValueTrait
{
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
