<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Pays;
use Exception;
use PHPUnit\Framework\TestCase;

class PaysTest extends TestCase
{
    public function setUp(): void
    {
        $this->belgique = new Pays('BE');
        $this->france = new Pays('FR');
    }

    public function testGetName()
    {
        $this->assertEquals('BE', $this->belgique->getName());
        $this->assertEquals('FR', $this->france->getName());
    }
}
