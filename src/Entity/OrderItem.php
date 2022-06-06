<?php


namespace App\Entity;


class OrderItem
{
    /**
     * @var Product
     */
    protected $item;

    /**
     * @param int $quantity
     */
    protected $quantity;

    public function __construct(Product $product, int $quantity)
    {
        $this->item = $product;
        $this->quantity = $quantity;
    }

    public function getProduct(): Product
    {
        return $this->item;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getTotalHt(): float
    {
        return $this->item->getPrice() * $this->quantity;
    }
}
