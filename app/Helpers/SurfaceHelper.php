<?php

namespace App\Helpers;

class SurfaceHelper
{

    public static function outOfBoundaries(float $width, float $height, float $x, float $y): bool {
        // calculate the relative surface area for each square on X and Y
        $relativeWidth  = round($width / 2, 1);
        $relativeHeight = round($height / 2, 1);

        return abs($x) > $relativeWidth || abs($y) > $relativeHeight;
    }

}
