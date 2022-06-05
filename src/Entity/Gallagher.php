<?php

namespace App\Entity;

use App\Entity\AbstractBrand;

class Gallagher extends AbstractBrand
{

    protected $name = 'Gallagher';
    private $DEFAULT_TVA = 1.2;

    public function getTva(): float
    {
        return $this->pays ? $this->pays->getTva() : $this->DEFAULT_TVA;
    }

    public function getMontantFraisTransport(Order $order): int
    {
        return 15;
    }
}
