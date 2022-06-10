<?php

namespace App\Service\Order;

use App\Entity\Order;
use App\Service\Pays\PaysVatService;

class OrderVatService
{
    private $paysVatService;

    public function __construct(PaysVatService $paysVatService)
    {
        $this->paysVatService = $paysVatService;
    }

    public function getVatAmount(Order $order): float
    {
        $pourcentageTvaTotal = 0;
        foreach ($order->getItems() as $item) {
            $pourcentageTvaTotal += ($this->paysVatService->getVat($item->getProduct()->getBrand()->getPays()) * $item->getQuantity());
        }
        return $order->getTotalHt() * (($pourcentageTvaTotal / $order->getTotalItems()) - 1);
    }
}
