<?php

namespace App\Entity\Brand;

use App\Entity\Brand\AbstractBrand;

class Gallagher extends AbstractBrand
{

    protected $name = 'Gallagher';
    private const TRANSPORT_COSTS = 15;

    public function getAmountTransportCosts(): int
    {
        return self::TRANSPORT_COSTS;
    }
}
