<?php

namespace App\Entity;

use App\Entity\AbstractBrand;


class Farmitoo extends AbstractBrand
{

    protected $name = 'Farmitoo';

    private $SEUIL_PRODUIT = 3;

    public function __construct()
    {
        parent::__construct();
    }

    public function getTva()
    {
        return 0.2;
    }

    public function getMontantFraisTransport(Order $order): int
    {
        $items_number = $order->getTotalItemsByBrand($this);

        if ($items_number % $this->SEUIL_PRODUIT == 0) {
            return ($items_number / $this->SEUIL_PRODUIT) * 15;
        }
        return (floor(($items_number / $this->SEUIL_PRODUIT) + 1)) * 15;
    }
}
