<?php

namespace App\Entity;

use App\Entity\Pays;

abstract class AbstractBrand
{

    protected $name;

    protected $pays;

    public function __construct(Pays $pays = null)
    {
        $this->name = $this->getName();
        $this->pays = $pays;
    }

    abstract protected function getTva(): float;
    abstract protected function getMontantFraisTransport(Order $order): ?int;

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }
}
