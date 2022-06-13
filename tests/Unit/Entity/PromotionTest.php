<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Order;
use App\Entity\Product;
use App\Entity\Brand\Farmitoo;
use App\Entity\Brand\Gallagher;
use App\Entity\Promotion;
use App\Entity\Vat\VatCountry;
use PHPUnit\Framework\TestCase;

class PromotionTest extends TestCase
{
    private $promotion;
    private $order;

    public function setUp(): void
    {
        $this->promotion = new Promotion(10, 5000, true, 5, new \DateTime('2020-01-01'), new \DateTime('2023-01-31'), 10);
        $farmitoo = new Farmitoo(new VatCountry(1.20));
        $gallagher = new Gallagher(new VatCountry(1.20));

        $product1 = new Product('Cuve à gasoil', 250000, $farmitoo);
        $product2 = new Product('Nettoyant pour cuve', 5000, $farmitoo);
        $product3 = new Product('Piquet de clôture', 1000, $gallagher);


        $this->order = (new Order())
            ->addItems($product1, 1)
            ->addItems($product2, 3)
            ->addItems($product3, 5);
    }

    public function testMinAmount()
    {
        $this->assertEquals(5000, $this->promotion->getMinAmount());
    }

    public function testReduction()
    {
        $this->assertEquals(10, $this->promotion->getReduction());
    }

    public function testFreeDelivery()
    {
        $this->assertTrue($this->promotion->getFreeDelivery());
    }

    public function testMinimumProduct()
    {
        $this->assertEquals(5, $this->promotion->getMinimumProduct());
    }

    public function testStartingDate()
    {
        $this->assertEquals(new \DateTime('2020-01-01'), $this->promotion->getStartingDate());
    }

    public function testEndingDate()
    {
        $this->assertEquals(new \DateTime('2023-01-31'), $this->promotion->getEndingDate());
    }

    public function testIsValid()
    {
        $this->assertTrue($this->promotion->isValid($this->order));
    }

    public function testIsNotValid()
    {
        $promotion = new Promotion(10, 10000, true, 100, new \DateTime('2020-01-01'), new \DateTime('2020-01-01'), 10);
        $this->assertFalse($promotion->isValid($this->order));
    }
}
