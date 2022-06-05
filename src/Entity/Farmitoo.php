<?php

namespace App\Entity;

use App\Entity\AbstractBrand;
use App\Entity\Pays;


class Farmitoo extends AbstractBrand
{

    protected $name = 'Farmitoo';

    private $SEUIL_PRODUIT = 3;
    private $DEFAULT_TVA = 1.2;

    public function getTva(): float
    {
        return $this->pays ? $this->pays->getTva() : $this->DEFAULT_TVA;
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
