<?php


namespace App\Entity;

use Exception;

class Order
{
    /**
     * @var OrderItem[]
     */
    protected $items;

    /**
     * @var Promotion[]
     */
    protected $promotions;

    public function __construct()
    {
        $this->items = [];
    }

    /**
     * @return  OrderItem[]
     */
    public function getItems()
    {
        return $this->items;
    }

    public function getTotalHt(): int
    {
        $totalPrice = 0;

        foreach ($this->items as $itemOrder) {
            $totalPrice += $itemOrder->getTotalHt();
        }

        return $totalPrice;
    }

    public function getSousTotalTtc(): int
    {
        $totalPrice = 0;

        foreach ($this->items as $itemOrder) {
            $totalPrice += $itemOrder->getTotalTtc();
        }

        return $totalPrice;
    }

    public function getMontantTva(): int
    {
        return $this->getSousTotalTtc() - $this->getTotalHt();
    }

    public function getMontantPromotions(): float
    {
        $totalPrice = 0;

        foreach ($this->promotions as $promotion) {
            $totalPrice += ($promotion->getReduction() * 100);
        }

        return $totalPrice;
    }

    public function getTotalTtc(): float
    {
        return $this->hasPromotion() ?
            ($this->getSousTotalTtc() + $this->getFraisDePort()) - $this->getMontantPromotions() : ($this->getSousTotalTtc() + $this->getFraisDePort());
    }

    public function getFraisDePort()
    {
        $brandInOrder = [];
        $montantFraisDePort = 0;

        foreach ($this->items as $itemOrder) {
            !in_array($itemOrder->getProduct()->getBrand(), $brandInOrder) ?
                array_push($brandInOrder, $itemOrder->getProduct()->getBrand()) : null;
        }

        foreach ($brandInOrder as $brand) {
            $montantFraisDePort += $brand->getMontantFraisTransport($this);
        }

        return $montantFraisDePort;
    }

    public function getTotalItems(): int
    {
        $totalItems = 0;

        foreach ($this->items as $itemOrder) {
            $totalItems += $itemOrder->getQuantity();
        }

        return $totalItems;
    }

    public function getTotalItemsByBrand(AbstractBrand $brand): int
    {
        $totalItems = 0;

        foreach ($this->items as $itemOrder) {
            if ($itemOrder->getProduct()->getBrand()->getName() == $brand->getName()) {
                $totalItems += $itemOrder->getQuantity();
            }
        }

        return $totalItems;
    }

    public function addItems(Product $product, int $quantity): self
    {
        $this->items[] = new OrderItem($product, $quantity);

        return $this;
    }

    public function addPromotions(Promotion $promotion): self
    {
        if ($promotion->isValid($this)) {
            $this->promotions[] = $promotion;

            return $this;
        }
        throw new Exception("Impossibler d'appliquer la promotion", 1);
    }

    public function hasPromotion()
    {
        return !empty($this->promotions);
    }
}
