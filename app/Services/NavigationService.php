<?php

namespace App\Services;

use App\Helpers\GlobeHelper;
use Illuminate\Support\Str;

class NavigationService
{

    const DEFAULT_STEP = 1;

    const NAV_MATRIX = [
        GlobeHelper::ORIENTATION_NORTH => [
            GlobeHelper::DIRECTION_LEFT    => [
                'factor' => -1,
                'coord'  => 0, // on X
            ],
            GlobeHelper::DIRECTION_RIGHT   => [
                'factor' => 1,
                'coord'  => 0, // on X
            ],
            GlobeHelper::DIRECTION_FORWARD => [
                'factor' => 1,
                'coord'  => 1, // on Y
            ],
        ],
        GlobeHelper::ORIENTATION_SOUTH => [
            GlobeHelper::DIRECTION_LEFT    => [
                'factor' => 1,
                'coord'  => 0, // on X
            ],
            GlobeHelper::DIRECTION_RIGHT   => [
                'factor' => -1,
                'coord'  => 0, // on X
            ],
            GlobeHelper::DIRECTION_FORWARD => [
                'factor' => -1,
                'coord'  => 1, // on Y
            ],
        ],
        GlobeHelper::ORIENTATION_EAST  => [
            GlobeHelper::DIRECTION_LEFT    => [
                'factor' => 1,
                'coord'  => 1, // on Y
            ],
            GlobeHelper::DIRECTION_RIGHT   => [
                'factor' => -1,
                'coord'  => 1, // on Y
            ],
            GlobeHelper::DIRECTION_FORWARD => [
                'factor' => 1,
                'coord'  => 0, // on X
            ],
        ],
        GlobeHelper::ORIENTATION_WEST  => [
            GlobeHelper::DIRECTION_LEFT    => [
                'factor' => -1,
                'coord'  => 1, // on Y
            ],
            GlobeHelper::DIRECTION_RIGHT   => [
                'factor' => 1,
                'coord'  => 1, // on Y
            ],
            GlobeHelper::DIRECTION_FORWARD => [
                'factor' => -1,
                'coord'  => 0, // on X
            ],
        ],
    ];

    private array $location;

    private string $orientation;

    public function setLocation(float $x, float $y, string $orientation)
    {
        if (!GlobeHelper::validateOrientation($orientation)) {
            throw new \UnexpectedValueException("Invalid orientation given: $orientation");
        }

        $this->location    = [$x, $y];
        $this->orientation = $orientation;
        return $this;
    }

    public function makeTurn(string $direction)
    {
        if (!GlobeHelper::validateDirection($direction)) {
            throw new \UnexpectedValueException("Invalid direction given: $direction");
        }

        $this->move(self::DEFAULT_STEP,
            self::NAV_MATRIX[$this->orientation][$direction]);
        return $this;
    }

    public function getLocation(): array
    {
        return $this->location;
    }

    public function getLatitude(): float
    {
        return $this->location[0];
    }

    public function getLongitude(): float
    {
        return $this->location[1];
    }

    private function move(float $step, array $navigation)
    {
        $this->location[$navigation['coord']] += $step * $navigation['factor'];
    }

}
