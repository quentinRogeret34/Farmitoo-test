<?php

namespace App\Service\Order;

use App\Entity\Order;

class OrderVatService
{

    public function getVatAmount(Order $order): float
    {
        $pourcentageTvaTotal = 0;
        foreach ($order->getItems() as $item) {
            $pourcentageTvaTotal += $item->getProduct()->getBrand()->getVat() * $item->getQuantity();
        }
        return $order->getTotalHt() * (($pourcentageTvaTotal / $order->getTotalItems()) - 1);
    }
}
