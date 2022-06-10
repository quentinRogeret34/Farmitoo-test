<?php

namespace App\Service\Order;

use App\Entity\Order;

class OrderPriceService
{
    private $orderVatService;
    private $orderTransportService;

    public function __construct(OrderVatService $orderVatService, OrderTransportService $orderTransportService)
    {
        $this->orderTransportService = $orderTransportService;
        $this->orderVatService = $orderVatService;
    }

    public function getAmountTtc(Order $order): float
    {
        return $this->orderVatService->getVatAmount($order) +
            $this->orderTransportService->getAmountTransportCosts($order) +
            $order->getTotalHt();
    }
}
