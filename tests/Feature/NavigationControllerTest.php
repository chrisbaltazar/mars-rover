<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NavigationControllerTest extends TestCase
{

    private array $payload;

    protected function setUp(): void
    {
        parent::setUp();
        $this->payload = [
            'width'        => 200,
            'height'       => 200,
            'originX'      => 0,
            'originY'      => 0,
            'orientation'  => 'N',
            'instructions' => 'FFLRR',
        ];
    }

    /**
     * @dataProvider provideWrongDirections
     */
    public function testWrongDirectionsGiven($input)
    {
        $data     = array_merge($this->payload, ['instructions' => $input]);
        $response = $this->post('/api/navigate', $data);
        $response->assertStatus(400);
        $response->assertSeeText('Invalid direction given');
    }

    public function provideWrongDirections()
    {
        return [
            ['FFRRLLW'],
            ['LLRRT'],
            ['LRRFFG'],
            ['WFFLLRR'],
        ];
    }

    /**
     * @dataProvider provideWronfInputData
     */
    public function testWrongDataInput($width, $height, $x, $y, $o)
    {
        $data     = array_merge($this->payload, [
            'width'       => $width,
            'height'      => $height,
            'originX'     => $x,
            'originY'     => $y,
            'orientation' => $o,
        ]);
        $response = $this->post('/api/navigate', $data);
        $response->assertStatus(400);
        $response->assertSeeText('The surface and origin data is wrong');
    }

    public function provideWronfInputData()
    {
        return [
            [100, 100, 99, 99, 'N'],
            [100, 100, 99, 99, 'E'],
            [100, 100, 99, -99, 'S'],
            [100, 100, -99, 99, 'W'],
        ];
    }

    /**
     * @dataProvider provideSuccessfulNavigation
     */
    public function testNavigationOk($width, $height, $x, $y, $o) {
        $this->withoutExceptionHandling();
        $data     = array_merge($this->payload, [
            'width'       => $width,
            'height'      => $height,
            'originX'     => $x,
            'originY'     => $y,
            'orientation' => $o,
        ]);
        $response = $this->post('/api/navigate', $data);
        $response->assertOk();
    }

    public function provideSuccessfulNavigation()
    {
        return [
            [100, 100, 0, 0, 'N'],
            [100, 100, 40, -40, 'E'],
            [100, 100, 30, -30, 'S'],
            [100, 100, -20, 10, 'W'],
        ];
    }

}
