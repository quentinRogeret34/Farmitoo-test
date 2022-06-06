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
     * @param int|null $reduction
     * @param int|null $minAmount
     * @param bool $freeDelivery
     * @param int|null $minimumProduct
     * @param DateTime|null $startingDate
     * @param DateTime|null $endingDate
     * @param int|null $usageNumber
     */
    public function __construct(
        int $reduction = null,
        int $minAmount = null,
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

    public function getReduction(): ?int
    {
        return $this->reduction;
    }

    public function getFreeDelivery(): ?bool
    {
        return $this->freeDelivery;
    }

    public function getUsageNumber(): ?int
    {
        return $this->usageNumber;
    }

    public function getMinAmount(): ?int
    {
        return $this->minAmount;
    }

    public function getStartingDate(): ?DateTime
    {
        return $this->startingDate;
    }

    public function getEndingDate(): ?DateTime
    {
        return $this->endingDate;
    }

    public function getMinimumProduct(): ?int
    {
        return $this->minimumProduct;
    }

    public function isValid(Order $order): bool
    {
        return $this->isValidMinimumAmount($order) &&
            $this->isValidMinimumProduct($order) &&
            $this->isValidDate() &&
            $this->isValidUsageNumber();
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
        if ($this->getUsageNumber() === null) {
            return true;
        }

        return $this->getUsageNumber() > 0;
    }
}
