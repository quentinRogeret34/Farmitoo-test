<?php

namespace App\Controller;

use App\Entity\Pays;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\Farmitoo;
use App\Entity\Gallagher;
use App\Entity\Promotion;
use App\Service\Order\OrderPriceService;
use App\Service\Order\OrderTransportService;
use App\Service\Order\OrderVatService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(
        OrderVatService $orderVatService,
        OrderTransportService $orderTransportService,
        OrderPriceService $orderPriceService
    ): Response {

        // Je passe une commande avec
        // Cuve à gasoil x1
        // Nettoyant pour cuve x3
        // Piquet de clôture x5

        $france = new Pays('FR');

        $farmitoo = new Farmitoo($france);
        $gallagher = new Gallagher($france);

        $product1 = new Product('Cuve à gasoil', 250000, $farmitoo);
        $product2 = new Product('Nettoyant pour cuve', 5000, $farmitoo);
        $product3 = new Product('Piquet de clôture', 1000, $gallagher);

        $promotion1 = new Promotion(8, 5000, false, 5);

        $order = (new Order())
            ->addItems($product1, 1)
            ->addItems($product2, 3)
            ->addItems($product3, 5)
            ->addPromotion($promotion1);


        return $this->render('shopping_cart/index.html.twig', [
            'order' => $order,
            'vatAmount' => $orderVatService->getVatAmount($order),
            'orderTransportService' => $orderTransportService,
            'orderPriceService' => $orderPriceService,
        ]);
    }

    /**
     * @Route("/payment", name="payment")
     */
    public function payment(): Response
    {
        return $this->render('payments/index.html.twig');
    }
}
