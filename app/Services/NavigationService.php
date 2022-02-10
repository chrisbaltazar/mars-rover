<?php

namespace App\Services;

use App\Helpers\GlobeHelper;
use Illuminate\Support\Str;

class NavigationService
{

    const DEFAULT_STEP = 1;

    const DIRECTION_FORWARD = 'F';

    const DIRECTION_LEFT = 'L';

    const DIRECTION_RIGHT = 'R';

    const ORIENTATION_NORTH = 'N';

    const ORIENTATION_SOUTH = 'S';

    const ORIENTATION_EAST = 'E';

    const ORIENTATION_WEST = 'W';

    const NAV_MATRIX = [
        self::ORIENTATION_NORTH => [
            self::DIRECTION_LEFT    => [
                'factor' => -1,
                'coord'  => 0, // on X
            ],
            self::DIRECTION_RIGHT   => [
                'factor' => 1,
                'coord'  => 0, // on X
            ],
            self::DIRECTION_FORWARD => [
                'factor' => 1,
                'coord'  => 1, // on Y
            ],
        ],
        self::ORIENTATION_SOUTH => [
            self::DIRECTION_LEFT    => [
                'factor' => 1,
                'coord'  => 0, // on X
            ],
            self::DIRECTION_RIGHT   => [
                'factor' => -1,
                'coord'  => 0, // on X
            ],
            self::DIRECTION_FORWARD => [
                'factor' => -1,
                'coord'  => 1, // on Y
            ],
        ],
        self::ORIENTATION_EAST  => [
            self::DIRECTION_LEFT    => [
                'factor' => 1,
                'coord'  => 1, // on Y
            ],
            self::DIRECTION_RIGHT   => [
                'factor' => -1,
                'coord'  => 1, // on Y
            ],
            self::DIRECTION_FORWARD => [
                'factor' => 1,
                'coord'  => 0, // on X
            ],
        ],
        self::ORIENTATION_WEST  => [
            self::DIRECTION_LEFT    => [
                'factor' => -1,
                'coord'  => 1, // on Y
            ],
            self::DIRECTION_RIGHT   => [
                'factor' => 1,
                'coord'  => 1, // on Y
            ],
            self::DIRECTION_FORWARD => [
                'factor' => -1,
                'coord'  => 0, // on X
            ],
        ],
    ];

    private array $location;

    private string $orientation;

    public function setLocation(float $x, float $y, string $orientation)
    {
        if (!$this->validateOrientation($orientation)) {
            throw new \UnexpectedValueException("Invalid orientation given: $orientation");
        }

        $this->location    = [$x, $y];
        $this->orientation = $orientation;
        return $this;
    }

    public function makeTurn(string $direction)
    {
        if (!$this->validateDirection($direction)) {
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

    private function validateDirection(string $direction): bool
    {
        return in_array($direction, [
            self::DIRECTION_FORWARD,
            self::DIRECTION_LEFT,
            self::DIRECTION_RIGHT,
        ]);
    }

    private function validateOrientation(string $orientation): bool
    {
        return in_array($orientation, [
            self::ORIENTATION_NORTH,
            self::ORIENTATION_SOUTH,
            self::ORIENTATION_EAST,
            self::ORIENTATION_WEST,
        ]);
    }

}
