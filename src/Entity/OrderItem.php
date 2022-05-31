<?php


namespace App\Entity;

use App\Service\TvaService;
use Locale;


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

    /**
     * @param int $quantity
     */
    protected $tvaService;

        /**
     * @param int $quantity
     */
    protected $tva;

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

    public function getTotalTtc(): int
    {
        // TODO : prendre en compte le % de TVA
        return ($this->item->getPrice() * $this->quantity) *1.20;
    }

    public function getTotalHt(): int
    {
        return $this->item->getPrice() * $this->quantity;
    }
}
