<?php

namespace App\Service\Order;

use App\Entity\Order;

class OrderTransportService
{
    public function getAmountTransportCosts(Order $order): float
    {
        if ($order->isFreeDelivery()) {
            return 0;
        }

        $brandInOrder = [];
        $montantFraisDePort = 0;

        foreach ($order->getItems() as $itemOrder) {
            !in_array($itemOrder->getProduct()->getBrand(), $brandInOrder) ?
                array_push($brandInOrder, $itemOrder->getProduct()->getBrand()) : null;
        }

        foreach ($brandInOrder as $brand) {
            $montantFraisDePort += $brand->getAmountTransportCosts($order);
        }

        return $montantFraisDePort;
    }
}
