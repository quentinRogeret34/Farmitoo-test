<?php

namespace App\Entity;

use App\Entity\AbstractBrand;

class Gallagher extends AbstractBrand
{

    protected $name = 'Gallagher';
    private $DEFAULT_VAT = 1.20;

    public function getVat(): float
    {
        return $this->pays ? $this->pays->getVat() : $this->DEFAULT_VAT;
    }

    public function getAmountTransportCosts(Order $order): int
    {
        return 15;
    }
}
