<?php

namespace App\Tests\Unit\Service;

use App\Entity\Pays;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\Brand\Farmitoo;
use App\Entity\Brand\Gallagher;
use App\Entity\Promotion;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Service\Order\OrderTransportService;

class OrderTransportServicePhpTest extends KernelTestCase
{
    private $orderTransportService;

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

        self::bootKernel();
        $this->orderTransportService = self::$container->get(OrderTransportService::class);
    }

    public function testGetAmountTransportCosts()
    {
        $this->assertEquals(45, $this->orderTransportService->getAmountTransportCosts($this->order));
    }

    public function testGetAmountTransportCostsWithPromotion()
    {
        $this->order->addPromotion(new Promotion(null, null, true));
        $this->assertEquals(0, $this->orderTransportService->getAmountTransportCosts($this->order));
    }
}
