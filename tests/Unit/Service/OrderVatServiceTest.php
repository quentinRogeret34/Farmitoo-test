<?php

namespace App\Service\Order;

use App\Entity\Pays;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\Brand\Farmitoo;
use App\Entity\Brand\Gallagher;
use App\Service\Order\OrderVatService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\Promotion;
use App\Entity\Vat\VatCountry;

class OrderVatServiceTest extends KernelTestCase
{
    private $orderVatService;

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
        $this->orderVatService = self::$container->get(OrderVatService::class);
    }

    public function testGetVatAmount()
    {
        $this->assertEquals(54000.00, $this->orderVatService->getVatAmount($this->order));
        $this->order->addPromotion(new Promotion(8, null, false));
        $this->assertEquals(53840.00, $this->orderVatService->getVatAmount($this->order));
    }
}
