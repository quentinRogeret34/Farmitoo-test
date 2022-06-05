<?php


namespace App\Entity;

use DateTime;

class Promotion
{
    /**
     * @var int
     */
    protected $minAmount;

    /**
     * @var int
     */
    protected $reduction;

    /**
     * @var bool
     */
    protected $freeDelivery;

    /**
     * @var int
     */
    protected $minimumProduct;

    /**
     * @var DateTime
     */
    protected $startingDate;

    /**
     * @var DateTime
     */
    protected $endingDate;

    /**
     * @var int
     */
    protected $usageNumber;

    /**
     * @param int $minAmount
     * @param int $reduction
     * @param bool $freeDelivery
     * @param int $minimumProduct
     * @param \DateTime $startingDate
     * @param \DateTime $endingDate
     * @param int $usageNumber    
     */
    public function __construct(
        int $minAmount = null,
        int $reduction,
        bool $freeDelivery = false,
        int $minimumProduct = null,
        \DateTime $startingDate = null,
        \DateTime $endingDate = null,
        int $usageNumber = null
    ) {
        $this->minAmount = $minAmount;
        $this->reduction = $reduction;
        $this->freeDelivery = $freeDelivery;
        $this->minimumProduct = $minimumProduct;
        $this->startingDate = $startingDate;
        $this->endingDate = $endingDate;
        $this->usageNumber = $usageNumber;
    }

    public function getReduction(): int
    {
        return $this->reduction;
    }

    public function isValid(Order $order): bool
    {
        return $this->isValidMinimumAmount($order) &&
            $this->isValidMinimumProduct($order) &&
            $this->isValidDate() &&
            $this->isValidUsageNumber();
    }


    public function getFreeDelivery(): bool
    {
        return $this->freeDelivery;
    }

    public function isValidMinimumAmount(Order $order): bool
    {
        return $this->minAmount === null || $order->getTotalHt() >= $this->minAmount;
    }

    public function isValidMinimumProduct(Order $order): bool
    {
        return $this->minimumProduct === null || $order->getTotalItems() >= $this->minimumProduct;
    }

    public function isValidDate(): bool
    {
        if ($this->endingDate === null) {
            return true;
        }

        $now = new \DateTime();
        return $now >= $this->startingDate && $now <= $this->endingDate;
    }

    public function isValidUsageNumber(): bool
    {
        if ($this->usageNumber === null) {
            return true;
        }

        return $this->usageNumber > 0;
    }
}
