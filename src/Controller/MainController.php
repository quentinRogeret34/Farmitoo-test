<?php

namespace App\Controller;

use Locale;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\Promotion;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {


        $product1 = new Product('Cuve à gasoil', 250000, 'Farmitoo');
        $product2 = new Product('Nettoyant pour cuve', 5000, 'Farmitoo');
        $product3 = new Product('Piquet de clôture', 1000, 'Gallagher');

        $promotion1 = new Promotion(50000, 8, false);

        $order = (new Order())
        ->addItems($product1, 1)
        ->addItems($product2, 3)
        ->addItems($product3, 5)
        ->addPromotions($promotion1);

        // Je passe une commande avec
        // Cuve à gasoil x1
        // Nettoyant pour cuve x3
        // Piquet de clôture x5

        return $this->render('shopping_cart/index.html.twig', [
            'order' => $order,
            'promotions' => [
                $promotion1,
            ],
        ]);
    }
}
