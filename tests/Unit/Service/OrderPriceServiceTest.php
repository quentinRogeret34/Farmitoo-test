<?php

use App\Entity\Pays;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\Brand\Farmitoo;
use App\Entity\Brand\Gallagher;
use App\Entity\Promotion;
use App\Service\Order\OrderPriceService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class OrderPriceServiceTest extends KernelTestCase
{
    private $orderPriceService;
    public function setUp(): void
    {
        $france = new Pays('FR');

        $farmitoo = new Farmitoo($france);
        $gallagher = new Gallagher($france);
        $product1 = new Product('Cuve à gasoil', 250000, $farmitoo);
        $product2 = new Product('Nettoyant pour cuve', 5000, $farmitoo);
        $product3 = new Product('Piquet de clôture', 1000, $gallagher);

        $this->order = (new Order())
            ->addItems($product1, 1)
            ->addItems($product2, 3)
            ->addItems($product3, 5);

        self::bootKernel();
        $this->orderPriceService = self::$container->get(OrderPriceService::class);
    }

    public function testGetAmountTtc()
    {
        $promotion = new Promotion(8, null, false);
        $this->assertEquals(324045.00, $this->orderPriceService->getAmountTtc($this->order));
        $this->order->addPromotion($promotion);
        $this->assertEquals(323085.00, $this->orderPriceService->getAmountTtc($this->order));
        $this->order->removePromotion($promotion);
        $this->assertEquals(324045.00, $this->orderPriceService->getAmountTtc($this->order));
    }
}
