<?php

namespace App\Entity;

use App\Entity\AbstractBrand;

class Farmitoo extends AbstractBrand
{

    protected $name = 'Farmitoo';

    private $PRODUIT_THRESHOLD = 3;
    private $DEFAULT_VAT = 1.2;
    private $TRANSPORT_PRICE = 15;

    public function getVat(): float
    {
        return $this->pays ? $this->pays->getVat() : $this->DEFAULT_VAT;
    }

    public function getAmountTransportCosts(Order $order): int
    {
        $items_number = $order->getTotalItemsByBrand($this);

        if ($items_number % $this->PRODUIT_THRESHOLD == 0) {
            return ($items_number / $this->PRODUIT_THRESHOLD) * $this->TRANSPORT_PRICE;
        }
        return (floor(($items_number / $this->PRODUIT_THRESHOLD) + 1)) * $this->TRANSPORT_PRICE;
    }
}
