<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Pays;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\Farmitoo;
use App\Entity\Gallagher;
use App\Entity\Promotion;
use Exception;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    public function setUp(): void
    {

        $france = new Pays('FR');

        $farmitoo = new Farmitoo($france);
        $gallagher = new Gallagher();

        $product1 = new Product('Cuve à gasoil', 250000, $farmitoo);
        $product2 = new Product('Nettoyant pour cuve', 5000, $farmitoo);
        $product3 = new Product('Piquet de clôture', 1000, $gallagher);

        $this->order = (new Order())
            ->addItems($product1, 1)
            ->addItems($product2, 3)
            ->addItems($product3, 5);
    }


    public function testGetAmountTransportCosts()
    {
        $this->assertEquals(45, $this->order->getAmountTransportCosts());
        $this->order->addPromotion(new Promotion(null, null, true));
        $this->assertEquals(0, $this->order->getAmountTransportCosts());
    }

    public function testGetVatAmount()
    {
        $this->assertEquals(54000.00, $this->order->getVatAmount());
        $this->order->addPromotion(new Promotion(8, null, false));
        $this->assertEquals(53840.00, $this->order->getVatAmount());
    }

    public function testGetAmountTtc()
    {
        $promotion = new Promotion(8, null, false);
        $this->assertEquals(324045.00, $this->order->getAmountTtc());
        $this->order->addPromotion($promotion);
        $this->assertEquals(323085.00, $this->order->getAmountTtc());

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Impossible d'appliquer la promotion");
        $this->order->addPromotion(new Promotion(10, 400000));

        $this->order->removePromotion($promotion);
        $this->assertEquals(324045.00, $this->order->getAmountTtc());
    }
}
