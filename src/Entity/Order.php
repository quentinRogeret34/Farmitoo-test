<?php


namespace App\Entity;


class Order
{
    /**
     * @var array
     */
    protected $items;

    protected $promotions;


    /**
     * Get the value of items
     *
     * @return  array
     */ 
    public function getItems()
    {
        return $this->items;
        return $this->promotions;
    }

    public function __construct()
    {
        $this->items = [];
    }

    public function getTotalHt(): int
    {
        $totalPrice = 0;

        foreach ($this->items as $itemOrder) {
            $totalPrice += $itemOrder->getTotalHt();
        }

        return $totalPrice;
    }

    public function getTotalTtc(): int
    {
        $totalPrice = 0;

        foreach ($this->items as $itemOrder) {
            $totalPrice += $itemOrder->getTotalTtc();
        }

        return $totalPrice;
    }

    public function getTva(): int
    {
        return $this->getTotalTtc() - $this->getTotalHt();
    }

    public function addItems(Product $product, int $quantity): self
    {
        $this->items[] = new OrderItem($product, $quantity);

        return $this;
    }

    public function addPromotions(Promotion $promotion): self
    {
        $this->promotions[] = $promotion;

        return $this;
    }
}
