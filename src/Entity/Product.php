<?php

namespace App\Entity;

use phpDocumentor\Reflection\Types\Float_;

class Product
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var int
     */
    protected $price;

    /**
     * @var string
     */
    protected $brand;

    /**
     * @param string $title
     * @param int $price
     * @param string $brand
     */
    public function __construct(string $title, int $price, string $brand)
    {
        $this->title = $title;
        $this->price = $price;
        $this->brand = $brand;
    }


    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getBrand(): string
    {
        return $this->brand;
    }

    /**
     * @return string
     */
    public function getPrice(): Float
    {
        return $this->price;
    }
}
