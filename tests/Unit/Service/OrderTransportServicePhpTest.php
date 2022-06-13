<?php

namespace App\Tests\Unit\Service;

use App\Entity\Pays;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\Promotion;
use App\Entity\Brand\Farmitoo;
use App\Entity\Vat\VatCountry;
use App\Entity\Brand\Gallagher;
use App\Service\Order\OrderTransportService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class OrderTransportServicePhpTest extends KernelTestCase
{
    private $orderTransportService;

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
