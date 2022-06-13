<?php

namespace App\Entity\Brand;

use App\Entity\Order;
use App\Entity\Brand\AbstractBrand;
use App\Entity\Vat\VatInterface;

class Farmitoo extends AbstractBrand implements VatInterface
{

    protected $name = 'Farmitoo';

    private const PRODUIT_THRESHOLD = 3;
    private const TRANSPORT_PRICE = 15;

    public function getAmountTransportCosts(Order $order): int
    {
        $items_number = $order->getTotalItemsByBrand($this);

        if ($items_number % self::PRODUIT_THRESHOLD == 0) {
            return ($items_number / self::PRODUIT_THRESHOLD) * self::TRANSPORT_PRICE;
        }
        return (floor(($items_number / self::PRODUIT_THRESHOLD) + 1)) * self::TRANSPORT_PRICE;
    }
}
