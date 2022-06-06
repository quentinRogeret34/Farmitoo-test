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

    public function testGetTva()
    {
        $this->assertEquals(1.19, $this->belgique->getVat());
        $this->assertEquals(1.2, $this->france->getVat());
    }

    public function testException()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("La TVA n'est pas définie pour ce pays");
        (new Pays('XX'))->getVat();
    }
}
