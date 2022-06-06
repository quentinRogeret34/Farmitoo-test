<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Pays;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\Gallagher;
use PHPUnit\Framework\TestCase;

class GallagherTest extends TestCase
{
    public function setUp(): void
    {
        $this->gallagher = new Gallagher();
        $this->gallagherWithPays = new Gallagher(new Pays('BE'));
    }

    public function testGetName()
    {
        $this->assertEquals('Gallagher', $this->gallagher->getName());
    }

    public function testGetTva()
    {
        $this->assertEquals(1.20, $this->gallagher->getVat());
        $this->assertEquals(1.19, $this->gallagherWithPays->getVat());
    }

    public function testGetAmountTransportCosts()
    {
        $order = new Order();
        $order->addItems(new Product('Piquet de clôture', 5000, $this->gallagher), 3);

        $this->assertEquals(15, $this->gallagher->getAmountTransportCosts($order));

        $order->addItems(new Product('Piquet de clôture', 1000, $this->gallagher), 1);

        $this->assertEquals(15, $this->gallagher->getAmountTransportCosts($order));
    }
}
