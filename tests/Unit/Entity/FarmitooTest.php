<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Pays;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\Brand\Farmitoo;
use App\Entity\Vat\VatBrand;
use PHPUnit\Framework\TestCase;

class FarmitooTest extends TestCase
{
    public function setUp(): void
    {
        $this->farmitoo = new Farmitoo(new VatBrand(1.20));
        $this->farmitooWithPays = new Farmitoo(new VatBrand(1.20));
    }

    public function testGetName()
    {
        $this->assertEquals('Farmitoo', $this->farmitoo->getName());
    }

    public function testgetAmountTransportCosts()
    {
        $order = new Order();
        $order->addItems(new Product('Nettoyant pour cuve', 5000, $this->farmitoo), 3);

        $this->assertEquals(15, $this->farmitoo->getAmountTransportCosts($order));

        $order->addItems(new Product('Nettoyant pour cuve', 1000, $this->farmitoo), 1);

        $this->assertEquals(30, $this->farmitoo->getAmountTransportCosts($order));
    }
}
