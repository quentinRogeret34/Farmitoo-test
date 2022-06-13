<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Pays;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\Promotion;
use App\Entity\Brand\Farmitoo;
use App\Entity\Vat\VatCountry;
use App\Entity\Brand\Gallagher;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    public function setUp(): void
    {

        $vatFrance = new VatCountry(1.20);
        $farmitoo = new Farmitoo($vatFrance);
        $gallagher = new Gallagher($vatFrance);

        $product1 = new Product('Cuve à gasoil', 250000, $farmitoo);
        $product2 = new Product('Nettoyant pour cuve', 5000, $farmitoo);
        $product3 = new Product('Piquet de clôture', 1000, $gallagher);

        $this->order = (new Order())
            ->addItems($product1, 1)
            ->addItems($product2, 3)
            ->addItems($product3, 5);
    }

    public function testGetTotalHt()
    {
        $this->assertEquals(270000, $this->order->getTotalHt());
    }
}
