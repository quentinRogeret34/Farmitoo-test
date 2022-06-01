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

    public function getFraisTransport(Order $order): int
    {
        foreach ($order->getItems() as $order) {
            if ($order->getProduct()->getBrand() == $this) {
                return 15;
            }
        }
    }
}
