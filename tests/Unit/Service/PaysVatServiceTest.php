<?php

namespace App\Tests\Unit\Service;

use App\Entity\Pays;
use App\Service\Pays\PaysVatService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PaysVatServiceTest extends KernelTestCase
{
    private $paysVatService;

    public function setUp(): void
    {

        $this->belgique = new Pays('BE');
        $this->france = new Pays('FR');

        self::bootKernel();
        $this->paysVatService = self::$container->get(PaysVatService::class);
    }

    public function testGetTva()
    {
        $this->assertEquals(1.19, $this->paysVatService->getVat($this->belgique));
        $this->assertEquals(1.2, $this->paysVatService->getVat($this->france));
    }
}
