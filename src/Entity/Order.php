<?php


namespace App\Entity;

use Exception;
use App\Entity\Promotion;

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

    public function getItems(): array
    {
        return $this->items;
    }

    public function getTotalHt(): int
    {
        return $this->getSubtotalHt() -  $this->getAmountPromotions();
    }

    public function getSubtotalHt(): int
    {
        $totalPrice = 0;

        foreach ($this->items as $itemOrder) {
            $totalPrice += $itemOrder->getTotalHt();
        }
        return $totalPrice;
    }

    public function getVatAmount(): int
    {
        $pourcentageTvaTotal = 0;
        foreach ($this->getItems() as $item) {
            $pourcentageTvaTotal += ($item->getProduct()->getBrand()->getVat() * $item->getQuantity());
        }
        return $this->getTotalHt() * (($pourcentageTvaTotal / $this->getTotalItems()) - 1);
    }

    public function getAmountPromotions(): float
    {
        $totalPrice = 0;

        foreach ($this->getPromotions() as $promotion) {
            $totalPrice += ($promotion->getReduction() * 100);
        }

        return $totalPrice;
    }

    public function getAmountTtc(): float
    {
        return $this->getVatAmount() + $this->getAmountTransportCosts() + $this->getTotalHt();
    }

    public function getAmountTransportCosts(): float
    {

        if ($this->isFreeDelivery()) {
            return 0;
        }
        $brandInOrder = [];
        $montantFraisDePort = 0;

        foreach ($this->items as $itemOrder) {
            !in_array($itemOrder->getProduct()->getBrand(), $brandInOrder) ?
                array_push($brandInOrder, $itemOrder->getProduct()->getBrand()) : null;
        }

        foreach ($brandInOrder as $brand) {
            $montantFraisDePort += $brand->getAmountTransportCosts($this);
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

    /**
     * @throws Exception
     */
    public function addPromotion(Promotion $promotion): self
    {
        if ($promotion->isValid($this)) {
            $this->promotions[] = $promotion;

            return $this;
        }
        throw new Exception("Impossible d'appliquer la promotion");
    }

    public function removePromotion(Promotion $promotion): self
    {
        if (in_array($promotion, $this->promotions)) {
            unset($this->promotions[array_search($promotion, $this->promotions)]);

            return $this;
        }
        throw new Exception("Impossible de supprimer la promotion");
    }

    public function hasPromotion(): bool
    {
        return !empty($this->promotions);
    }

    public function isFreeDelivery(): bool
    {

        foreach ($this->getPromotions() as $promotion) {
            if ($promotion->isValid($this) && $promotion->getFreeDelivery()) {
                return true;
            }
        }
        return false;
    }

    public function getPromotions(): array
    {
        return $this->promotions ?: [];
    }
}
