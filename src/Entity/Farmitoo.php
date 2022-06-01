<?php

namespace App\Entity;

use App\Entity\AbstractBrand;


class Farmitoo extends AbstractBrand
{

    protected $name = 'Farmitoo';

    public function __construct()
    {
        parent::__construct();
    }

    public function getTva()
    {
        return 0.2;
    }

    public function getFraisTransport(Order $order): int
    {
        foreach ($order->getItems() as $order) {
            if ($order->getProduct()->getBrand()->getName() == $this->name) {
                // TODO : filtrer pour récupérer uniquement les produits de la marque
                // -> Appliquer le calcul du fdp 20€ par tranche de 3 produits entamée 
                return 10;
            }
        }
    }
}
