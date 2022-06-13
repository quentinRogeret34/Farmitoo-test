<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Pays;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\Brand\Gallagher;
use App\Entity\Vat\VatCountry;
use PHPUnit\Framework\TestCase;

class GallagherTest extends TestCase
{
    public function setUp(): void
    {
        $this->gallagher = new Gallagher(new VatCountry(1.20));
        $this->gallagherWithPays = new Gallagher(new VatCountry(1.20));
    }

    public function testGetName()
    {
        $this->assertEquals('Gallagher', $this->gallagher->getName());
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
