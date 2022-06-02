<?php

namespace App\Entity;

use App\Entity\AbstractBrand;

class Gallagher extends AbstractBrand
{

    protected $name = 'Gallagher';

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
        return 15;
    }
}
