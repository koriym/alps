<?php

declare(strict_types=1);

namespace Koriym\Alps;

use PHPUnit\Framework\TestCase;

class AlpsTest extends TestCase
{
    /**
     * @var Alps
     */
    protected $alps;

    protected function setUp() : void
    {
        $this->alps = new Alps;
    }

    public function testIsInstanceOfAlps() : void
    {
        $actual = $this->alps;
        $this->assertInstanceOf(Alps::class, $actual);
    }
}
