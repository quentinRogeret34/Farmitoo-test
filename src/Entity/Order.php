<?php


namespace App\Entity;

use Exception;
use App\Entity\Promotion;
use App\Entity\Brand\AbstractBrand;

class Order
{

    protected $items;
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

    public function getAmountPromotions(): float
    {
        $totalPrice = 0;

        foreach ($this->getPromotions() as $promotion) {
            $totalPrice += ($promotion->getReduction() * 100);
        }

        return $totalPrice;
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
            if ($itemOrder->getProduct()->getBrand() == $brand) {
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

    /**
     * @throws Exception
     */
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
