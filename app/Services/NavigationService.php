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
                'coord'  => 'x',
            ],
            GlobeHelper::DIRECTION_RIGHT   => [
                'factor' => 1,
                'coord'  => 'x',
            ],
            GlobeHelper::DIRECTION_FORWARD => [
                'factor' => 1,
                'coord'  => 'y',
            ],
        ],
        GlobeHelper::ORIENTATION_SOUTH => [
            GlobeHelper::DIRECTION_LEFT    => [
                'factor' => 1,
                'coord'  => 'x',
            ],
            GlobeHelper::DIRECTION_RIGHT   => [
                'factor' => -1,
                'coord'  => 'x',
            ],
            GlobeHelper::DIRECTION_FORWARD => [
                'factor' => -1,
                'coord'  => 'y',
            ],
        ],
        GlobeHelper::ORIENTATION_EAST  => [
            GlobeHelper::DIRECTION_LEFT    => [
                'factor' => 1,
                'coord'  => 'y',
            ],
            GlobeHelper::DIRECTION_RIGHT   => [
                'factor' => -1,
                'coord'  => 'y',
            ],
            GlobeHelper::DIRECTION_FORWARD => [
                'factor' => 1,
                'coord'  => 'x',
            ],
        ],
        GlobeHelper::ORIENTATION_WEST  => [
            GlobeHelper::DIRECTION_LEFT    => [
                'factor' => -1,
                'coord'  => 'y',
            ],
            GlobeHelper::DIRECTION_RIGHT   => [
                'factor' => 1,
                'coord'  => 'y',
            ],
            GlobeHelper::DIRECTION_FORWARD => [
                'factor' => -1,
                'coord'  => 'x',
            ],
        ],
    ];

    private float $x;

    private float $y;

    private string $orientation;

    public function setLocation(float $x, float $y, string $orientation)
    {
        if (!GlobeHelper::validateOrientation($orientation)) {
            throw new \UnexpectedValueException("Invalid orientation given: $orientation");
        }

        $this->x           = $x;
        $this->y           = $y;
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
        return [$this->x, $this->y];
    }

    private function move(float $step, array $navigation)
    {
        $point = &$this->$navigation['coord'];
        $point += $step * $navigation['factor'];
    }

}
