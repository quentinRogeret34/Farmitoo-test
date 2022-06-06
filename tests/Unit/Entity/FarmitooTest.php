<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Pays;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\Farmitoo;
use PHPUnit\Framework\TestCase;

class FarmitooTest extends TestCase
{
    public function setUp(): void
    {
        $this->farmitoo = new Farmitoo();
        $this->farmitooWithPays = new Farmitoo(new Pays('BE'));
    }

    public function testGetName()
    {
        $this->assertEquals('Farmitoo', $this->farmitoo->getName());
    }

    public function testGetTva()
    {
        $this->assertEquals(1.20, $this->farmitoo->getTva());
        $this->assertEquals(1.19, $this->farmitooWithPays->getTva());
    }

    public function testGetMontantFraisTransport()
    {
        $order = new Order();
        $order->addItems(new Product('Nettoyant pour cuve', 5000, $this->farmitoo), 3);

        $this->assertEquals(15, $this->farmitoo->getMontantFraisTransport($order));

        $order->addItems(new Product('Nettoyant pour cuve', 1000, $this->farmitoo), 1);

        $this->assertEquals(30, $this->farmitoo->getMontantFraisTransport($order));
    }
}