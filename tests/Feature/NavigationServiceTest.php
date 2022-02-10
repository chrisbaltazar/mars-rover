<?php

namespace Tests\Feature;

use App\Services\NavigationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NavigationServiceTest extends TestCase
{

    private NavigationService $test;

    public function setUp(): void
    {
        parent::setUp();
        $this->test = new NavigationService();
    }

    public function testNavigateNorth()
    {
        $this->test->setLocation(0, 0, 'N');
        $this->test->makeTurn('L')->makeTurn('F')->makeTurn('F');

        $this->assertEquals([-1, 2], $this->test->getLocation());
    }

    public function testNavigateSouth()
    {
        $this->test->setLocation(0, 0, 'S');
        $this->test->makeTurn('L')->makeTurn('F')->makeTurn('F');

        $this->assertEquals([1, -2], $this->test->getLocation());
    }

    public function testNavigateEast()
    {
        $this->test->setLocation(0, 0, 'E');
        $this->test->makeTurn('L')->makeTurn('F')->makeTurn('F');

        $this->assertEquals([2, 1], $this->test->getLocation());
    }

    public function testNavigateWest()
    {
        $this->test->setLocation(0, 0, 'W');
        $this->test->makeTurn('L')->makeTurn('F')->makeTurn('F');

        $this->assertEquals([-2, -1], $this->test->getLocation());
    }
}
