<?php

namespace App\Helpers;

class GlobeHelper
{
    const DIRECTION_FORWARD = 'F';

    const DIRECTION_LEFT = 'L';

    const DIRECTION_RIGHT = 'R';

    const ORIENTATION_NORTH = 'N';

    const ORIENTATION_SOUTH = 'S';

    const ORIENTATION_EAST = 'E';

    const ORIENTATION_WEST = 'W';

    public static function validateDirection(string $direction): bool
    {
        return in_array($direction, [
            self::DIRECTION_FORWARD,
            self::DIRECTION_LEFT,
            self::DIRECTION_RIGHT,
        ]);
    }

    public static function validateOrientation(string $orientation): bool
    {
        return in_array($orientation, [
            self::ORIENTATION_NORTH,
            self::ORIENTATION_SOUTH,
            self::ORIENTATION_EAST,
            self::ORIENTATION_WEST,
        ]);
    }

}
