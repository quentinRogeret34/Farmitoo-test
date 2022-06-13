<?php

namespace App\Entity\Brand;

use App\Entity\Vat\VatInterface;

abstract class AbstractBrand
{

    protected $name;

    protected $pays;

    public function __construct(VatInterface $vat)
    {
        $this->name = $this->getName();
        $this->vat = $vat;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getVat(): float
    {
        return $this->vat->getVat();
    }
}
