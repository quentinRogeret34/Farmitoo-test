<?php

namespace App\Entity;


abstract class AbstractBrand
{

    protected $name;

    public function __construct()
    {
        $this->name = $this->getName();
    }

    abstract protected function getTva();
    abstract protected function getMontantFraisTransport(Order $order): ?int;

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }
}
